<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class AnaliseController extends Controller
{
  public $naturais = ['C','D','E','F','G','A','B'];
  private $numeros = ['2', '3', '4', '5', '6', '7', '9'];
  private $intComposto = ['0', '1', '2', '3', '4'];
  private $cifra;
  private $texto;
  public $parentesis = "fechado";
  public $statusAnalise = 'aberta';

  function analisar1(CifraController $cifra, TextoController $texto, $chor)
  {
    $this->cifra = $cifra;
    $this->texto = $texto;
    $s = 1; //índice do $chor a ser analizado
    $ac = $chor[1]; //analizar este caractere dentro do $chor
    return AnaliseController::space($chor, $ac, $s);
  }

  function pre_positivo($chor, CifraController $cifra)
  {
    $this->cifra = $cifra;
    AnaliseController::positivo($chor);
  }

  function positivo($chor){
    echo '<br>';
    var_dump($this->cifra);
    $this->statusAnalise = 'fechada';
    static $contaAcordes = 1;
    $positivo = $this->cifra->formataPositivo($chor);//retorna array
    echo "<br/> - $positivo[0] - $positivo[1] - é o $contaAcordes ° acorde";
    $contaAcordes ++;
    $this->cifra->setCifraDefault($positivo);
  }

  function increm($chor, $s)
  { 
    echo '<br>'.$chor[$s];
    echo '<br> strlen '.strlen($chor);
    echo '<br>';
    
    //echo '<br>';
    $s ++;
    $ac = $chor[$s];
    
    AnaliseController::space($chor, $ac, $s);
  }

  function space($chor, $ac, $s)
  {
    var_dump($this->cifra);
    if(($ac == ' ')||($this->cifra->invertido == 'sim')){ // acho que perde o objeto na segunda vez que passa. ver fluxo.
      if(
        (($chor[0] == "E")||($chor[0] == "A"))
        &&(($s == 1)||(($s == 2)&&($chor[1] == 'm')))
        &&($this->cifra->invertido == 'nao')){
        $rotacionar = AuxiliarController::seEouA($this->texto->texto[$this->texto->ea -2], $chor, $s); //:array 
        $funcao = array_shift($rotacionar);
        AnaliseController::$funcao(...$rotacionar); //positivo(chor) || increm(chor, s)
      }else{
        $chor = substr($chor, 0, ($s));
        AnaliseController::positivo($chor);
      }
    }elseif(($ac == '#')||($ac == 'b')&&(($s == 1)||($this->cifra->dissonancia == "sim"))){
      AuxiliarController::processaSustenidoEBemol($this->cifra, $ac, $s);
      AnaliseController::increm($chor, $s);
    }elseif((($ac == 'm')&&($s == 1))&&($this->cifra->composto == "nao")||(($ac == 'm')&&($s == 2)&&($this->cifra->enarmonia == "sim")&&($this->cifra->composto == "nao"))){
      //$this->cifra->enarmonia = "nao";
      $this->cifra->terca = "testada";
      AnaliseController::increm($chor, $s);
    }elseif((($ac == '+')||($ac == '-')&&($this->cifra->composto == "nao"))&&(($s == 1)||($this->cifra->dissonancia == "sim")&&($this->cifra->composto == "nao"))){
      $this->cifra->dissonancia = "nao";
      AnaliseController::increm($chor, $s);
    }elseif(($ac == '/')&&($this->cifra->composto == "nao")){
      $this->cifra->dissonancia = "nao";
      $rotacionar = AuxiliarController::bar($this->cifra, $this->naturais, $chor, $ac, $s);
      $funcao = array_shift($rotacionar);
      AnaliseController::$funcao(...$rotacionar); //space( chor, ac s ) || increm(chor, s)
    }elseif(($ac == '(')&&($this->parentesis == "fechado")&&($this->cifra->composto == "nao")){
      $rotacionar = AuxiliarController::parentesis($chor, $ac, $s);
       $funcao = array_shift($rotacionar);
       AnaliseController::$funcao(...$rotacionar); //space( chor, ac s ) || increm(chor, s)
    }elseif(($ac == ')')&&($this->parentesis == "aberto")&&($this->cifra->composto == "nao")){
      $this->cifra->dissonancia = "nao";
      $this->parentesis = "fechado";
      AnaliseController::increm($chor, $s);
    }elseif(in_array($ac, $this->numeros)&&($this->cifra->dissonancia == "nao")&&($this->cifra->composto == "nao")){  //numeros de 2 a 9.
      AuxiliarController::numOk($this->cifra, $chor, $s);
      AnaliseController::increm($chor, $s);
    }elseif(($ac == "1")&&($this->cifra->dissonancia == "nao")&&($this->cifra->composto == "nao")){  //numero 1 para contruir 10 a 14
      AuxiliarController::compostoIncompleto($this->cifra);
      AnaliseController::increm($chor, $s);
    }elseif((in_array($ac, $this->intComposto))&&($this->cifra->composto == "sim")){  //numeros de 10 a 14
      AuxiliarController::compostoCompleto($this->cifra);
      AnaliseController::increm($chor, $s);
    }elseif((($ac == 'd')&&($s == 1))||(($s == 2)&&($this->cifra->enarmonia == "sim"))){  //dim
      $rotacionar = AuxiliarController::seDim($chor, $s);
      AnaliseController::increm($rotacionar[0], $rotacionar[1]);
    }else{
      $this->statusAnalise = 'fechada';
      $this->parentesis = "fechado";
      $this->cifra->composto = "nao";
      $this->cifra->enarmonia = "nao";
      $this->cifra->dissonancia = "nao";
      $this->cifra->sustOuBemol = "natural";
      $this->cifra->sustOuBemolInv = "naturalInv";
      $this->cifra->possivelInversao = 'nao';
      echo "<br/>$chor não é acorde!";
      $pularCaracteres = strpos($chor, ' ');
      return $pularCaracteres;
    }
  }//space*/
}//classe
