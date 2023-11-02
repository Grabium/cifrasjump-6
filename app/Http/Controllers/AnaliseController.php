<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class AnaliseController extends Controller
{
  public $naturais = ['C','D','E','F','G','A','B'];
  private $cifra;
  private $texto;
  pulbic $parentesis = "fechado";

  function __construct()
  {
      //
  }

  function analisar1(CifraController $cifra, TextoController $texto, $chor){
    $this->cifra = $cifra;
    $this->texto = $texto;
    $s = 1; //índice do $chor a ser analizado
    $ac = $chor[1]; //analizar este caractere dentro do $chor
    AnaliseController::space($chor, $ac, $s);
  }

  function pre_positivo($chor, CifraController $cifra)
  {
    $this->cifra = $cifra;
    AnaliseController::positivo($chor);
  }

  function positivo($chor){ 
    $positivo = $this->cifra->formataPositivo($chor);//retorna array
    echo "<br /> - $positivo[0] - $positivo[1] - é um acorde<br />";
    $this->cifra->setCifraDefault($positivo);
    //dd($this->cifra);
    //$this->conversor->converter($positivo);
  }

  function increm($chor, $s){
    /*
    static $contador = 1;
    echo "<br> incrementado $contador vez(es).";
    $contador ++;
    */
    
    $s ++;
    echo "<br>s increm: [$s]<br>";
    $ac = $chor[$s];
    AnaliseController::space($chor, $ac, $s);
  }

  function space($chor, $ac, $s){
    if(($ac == ' ')||($this->cifra->invertido == 'sim')){ // acho que perde o objeto na segunda vez que passa. ver fluxo.
      if(($s == 1)&&(($chor[0] == "E")||($chor[0] == "A"))&&($this->cifra->invertido == 'nao')){
        $rotacionar = AuxiliarController::seEouA($this->texto, $chor, $ac, $s); //:array 
        $funcao = array_shift($rotacionar);
        AnaliseController::$funcao(...$rotacionar); //positivo(chor) || increm(chor, s)
        /*if($rotacionar[0] == 'positivo'){
          AnaliseController::positivo($rotacionar[1]); //positivo($chor)
        }else if($rotacionar[0] == 'increm'){
          AnaliseController::increm($chor, $s);
        }*/
      }else{
        $chor = substr($chor, 0, ($s));
        AnaliseController::positivo($chor);
      }
    }elseif(($ac == '#')||($ac == 'b')&&(($s == 1)||($this->cifra->dissonancia == "sim"))){
      AuxiliarController::processaSustenidoEBemol($this->cifra, $s, $ac);
      AnaliseController::increm($chor, $s);
    }elseif((($ac == 'm')&&($s == 1))&&($this->cifra->composto == "nao")||(($ac == 'm')&&($s == 2)&&($this->cifra->enarmonia == "sim")&&($this->cifra->composto == "nao"))){
      $this->cifra->enarmonia = "nao";
      $this->cifra->terca = "testada";
      AnaliseController::increm($chor, $s);
    }elseif((($ac == '+')||($ac == '-')&&($this->cifra->composto == "nao"))&&(($s == 1)||($this->cifra->dissonancia == "sim")&&($this->cifra->composto == "nao"))){
      $this->cifra->dissonancia = "nao";
      AnaliseController::increm($chor, $s);
    }elseif(($ac == '/')&&($this->cifra->composto == "nao")){
      $this->cifra->dissonancia = "nao";
      $rotacionar = AuxiliarController::bar($this->cifra, $chor, $ac, $s);
      $funcao = array_shift($rotacionar);
      AnaliseController::$funcao(...$rotacionar); //space( chor, ac s ) || increm(chor, s)
    }elseif(($ac == '(')&&($this->parentesis == "fechado")&&($this->cifra->composto == "nao")){
      $rotacionar = AuxiliarController::parentesis($chor, $ac, $s);
       $funcao = array_shift($rotacionar);
       AnaliseController::$funcao(...$rotacionar); //space( chor, ac s ) || increm(chor, s)
    }elseif(($ac == ')')&&($this->parentesis == "aberto")&&($this->cifra->composto == "nao")){//======================= continuar daqui.
      $this->cifra->dissonancia = "nao";
      $this->parentesis = "fechado";
      AnaliseController::increm($chor, $ac, $s);
    }elseif(in_array($ac, $this->numeros)&&($this->cifra->dissonancia == "nao")&&($this->cifra->composto == "nao")){  //numeros de 2 a 9.
      AuxiliarController::numOk($chor, $ac, $s);
    }elseif(($ac == "1")&&($this->cifra->dissonancia == "nao")&&($this->cifra->composto == "nao")){  //numero 1 para contruir 10 a 14
      AuxiliarController::compostoIncompleto($chor, $ac, $s);
    }elseif((in_array($ac, $this->intComposto))&&($this->cifra->composto == "sim")){  //numeros de 10 a 14
      AuxiliarController::compostoCompleto($chor, $ac, $s);
    }elseif((($ac == 'd')&&($s == 1))||(($s == 2)&&($this->cifra->enarmonia == "sim"))){  //dim
      AuxiliarController::seDim($chor, $ac, $s);
    }else{
      $this->parentesis = "fechado";
      
      $this->cifra->composto = "nao";
      $this->cifra->enarmonia = "nao";
      $this->cifra->dissonancia = "nao";
      $this->cifra->sustOuBemol = "natural";
      $this->cifra->sustOuBemolInv = "naturalInv";
      echo "<br/>$chor não é acorde!<br /><br />";
    }
  }//space*/
}//classe
