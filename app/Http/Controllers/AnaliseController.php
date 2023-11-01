<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class AnaliseController extends Controller
{
  public $naturais = ['C','D','E','F','G','A','B'];
  private $cifra;
  private $texto;

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

  function space($chor, $ac, $s){
    //
    if(($ac == ' ')||($this->cifra->getInvertido() == 'sim')){ 
      if(($s == 1)&&(($chor[0] == "E")||($chor[0] == "A"))&&($this->cifra->getInvertido() == 'nao')){
        $rotacionar = AuxiliarController::seEouA($this->texto, $chor, $ac, $s); 
        //dd($rotacionar);
        if($rotacionar[0] == 'positivo'){
          echo 'ea positivo';
        }elseif('increm'){
          echo 'ea incrementar';
        }
      }else{
        $chor = substr($chor, 0, ($s));
        Echo"<br/>ponto a .$ac.";}}}/*
        PrincipalController::positivo($chor);
      }
    }elseif(($ac == '#')||($ac == 'b')&&(($s == 1)||($this->dissonancia == "sim"))){
      if($s == 1){
        $this->enarmonia = "sim";
        if($ac == '#'){
          $this->sustOuBemol = "sustenido";
        }elseif($ac == 'b'){
          $this->sustOuBemol = "bemol";
        }
      }      
      $this->dissonancia = "nao";
      PrincipalController::increm($chor, $ac, $s);
    }elseif((($ac == 'm')&&($s == 1))&&($this->composto == "nao")||(($ac == 'm')&&($s == 2)&&($this->enarmonia == "sim")&&($this->composto == "nao"))){
      $this->enarmonia == "nao";
      $this->terca = "testada";
      PrincipalController::increm($chor, $ac, $s);
    }elseif((($ac == '+')||($ac == '-')&&($this->composto == "nao"))&&(($s == 1)||($this->dissonancia == "sim")&&($this->composto == "nao"))){
      $this->dissonancia = "nao";
      PrincipalController::increm($chor, $ac, $s);
    }elseif(($ac == '/')&&($this->composto == "nao")){
      $this->dissonancia = "nao";
      PrincipalController::bar($chor, $ac, $s);
    }elseif(($ac == '(')&&($this->parentesis == "fechado")&&($this->composto == "nao")){
      PrincipalController::parentesis($chor, $ac, $s);
    }elseif(($ac == ')')&&($this->parentesis == "aberto")&&($this->composto == "nao")){
      $this->dissonancia = "nao";
      $this->parentesis = "fechado";
      PrincipalController::increm($chor, $ac, $s);
    }elseif(in_array($ac, $this->numeros)&&($this->dissonancia == "nao")&&($this->composto == "nao")){  //numeros de 2 a 9.
      PrincipalController::numOk($chor, $ac, $s);
    }elseif(($ac == "1")&&($this->dissonancia == "nao")&&($this->composto == "nao")){  //numero 1 para contruir 10 a 14
      PrincipalController::compostoIncompleto($chor, $ac, $s);
    }elseif((in_array($ac, $this->intComposto))&&($this->composto == "sim")){  //numeros de 10 a 14
      PrincipalController::compostoCompleto($chor, $ac, $s);
    }elseif((($ac == 'd')&&($s == 1))||(($s == 2)&&($this->enarmonia == "sim"))){  //dim
      //echo "teste dim";
      PrincipalController::seDim($chor, $ac, $s);
    }else{
      $this->composto = "nao";
      $this->enarmonia = "nao";
      $this->dissonancia = "nao";
      $this->parentesis = "fechado";
      $this->sustOuBemol = "natural";
      $this->sustOuBemolInv = "naturalInv";
      echo "<br/>$chor não é acorde!<br /><br />";
    }
  }//space*/
}
