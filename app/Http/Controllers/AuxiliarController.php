<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\AnaliseController;

class AuxiliarController extends Controller
{
  
  public static function seEouA($ea, $chor, $s){
    if((($ea == "%")||($ea == '.'))
      &&(!in_array($chor[2], (new AnaliseController)->naturais)
      &&($chor[2] != "%"))){//&&($chor[1] != " ") 3º analise
      $chor = "*eanao*";//o if acima testa se a letra é início de frase.
      return ['increm', $chor, $s]; //AnaliseController::increm($chor, $s);
    }elseif(($ea == "%")
           &&($chor[1] == 'm')
           &&(!in_array($chor[3], (new AnaliseController)->naturais)
           &&($chor[3] != "%"))){
      $chor = "*eanao*";
      return ['increm', $chor, $s];
    }else{
      $chor = substr($chor, 0, $s);
      return ['positivo', $chor]; // encaminha para AnaliseController::positivo($chor);
    }
  }
  

  public static function processaSustenidoEBemol(CifraController $cifra, $ac, $s)
  {
    if($s == 1){
      $cifra->enarmonia = "sim";
      if($ac == '#'){
        $cifra->sustOuBemol = "sustenido";
      }elseif($ac == 'b'){
        $cifra->sustOuBemol = "bemol";
      }
    }      
    $cifra->dissonancia = "nao";
  }

  public static function bar(CifraController $cifra, $naturais, $chor, $ac, $s)
  {
    $s ++;
    $ac = $chor[$s];
    if(in_array($ac, $naturais)){
      $cifra->possivelInversao = 'sim';
      $s ++;
      $ac = $chor[$s];
      if($ac == " "){
        $cifra->tomDaInversao = $chor[$s-1];//array($s - 1, 1);
        $cifra->invertido = 'sim';
        $cifra->sustOuBemolInv = "naturalInv";
        return ['space', $chor, $ac, $s];//AnaliseController::space($chor, $ac, $s);
      }elseif(($ac == '#')||($ac == 'b')){
        if($ac == '#'){
          $cifra->sustOuBemolInv = "sustenidoInv";
        }elseif($ac == 'b'){
          $cifra->sustOuBemolInv = "bemolInv";
        }
        $s ++;
        $ac = $chor[$s];
        if($ac == " "){
          $cifra->tomDaInversao = $chor[$s-2].$chor[$s-1];//array($s - 2, 2);
          $cifra->invertido = 'sim';
          return ['space', $chor, $ac, $s];//AnaliseController::space($chor, $ac, $s);
        }
      }else{
        return AuxiliarController::seNum($cifra, $chor, $ac, $s);
      }
    }else{
      return AuxiliarController::seNum($cifra, $chor, $ac, $s);
    }//bloco do if(in_array...
  }//bar()

  public static function seNum(CifraController $cifra, $chor, $ac, $s){
    $numeros = ['2', '3', '4', '5', '6', '7', '9'];
    if((in_array($ac, $numeros))&&($cifra->dissonancia == "nao")){
      return AuxiliarController::numOk($cifra, $chor, $s);
    }else{
      return ['space', $chor, $ac, $s];;
    }
  }

  public static function numOk(CifraController $cifra, $chor, $s){
      $cifra->dissonancia = "sim";
      return ['increm', $chor, $s]; //AnaliseController::increm($chor, $s);
  }

  public static function parentesis(CifraController $cifra, $chor, $ac, $s){
    $s ++;
    $ac = $chor[$s];
    return AuxiliarController::seNum($cifra, $chor, $ac, $s);
  }

  public static function compostoIncompleto(CifraController $cifra)
  {
    $cifra->composto = "sim"; 
  }

  public static function compostoCompleto(CifraController $cifra){
    $cifra->composto = "nao";
    $cifra->dissonancia = "sim";
  }

  public static function seDim($chor, $s){
    $dim = substr($chor, $s, 3); //espera receber a string ["d","i","m"]
    if($dim == "dim"){
      $s = ($s+2);
    }
    return [$chor, $s];
  }

  

  public static function seMarcado($arr, $chor, $s)//arr recebe a array de acordo com as regras musicais
  {
    $trecho = substr($chor, $s, 6);//espera receber marcador sem espaço.
    if(array_search($trecho, $arr)){//se o marcador pertence à array.
      $pularCaracteres = (strpos($chor, ' ')-1);
      /*TESTE*///settype($pularCaracteres, 'string');echo "<br>pular caracteres em marcado:..$pularCaracteres..";
      $pularS = array_keys($arr, $trecho);//recebe o tipo original sem espaço.
      $chor = substr_replace($chor, $pularS, $s, 6);//recebe acorde original com espaço.
      $s = ($s + strlen($pularS[0]) -1);
    }
    return [$chor, $s, $pularCaracteres];//correr o $s até o [-1] de $trecho.
  }

  public static function repor($chor, $s)
  {
    $s ++;
    $trecho = substr($chor, $s, 2);
    if(($trecho == ("_1"))||($trecho == ("_2"))||($trecho == ("_3"))){
      $chor = substr_replace($chor, '', $s, 2);
    }
    return $chor;
  }
}
