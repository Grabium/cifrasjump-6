<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\AnaliseController;

class AuxiliarController extends Controller
{
  
  
  
  function endString($chor){
    echo "\n";echo __METHOD__;echo "\n";
    $l = strlen($chor);
    if($l == 1){
      return "positivo"; //último caractere dentro de naturais. É um acorde. 
    }else{
      $chor = $chor . " ";
      return $chor;
    }
  }

  public static function seEouA($ea, $chor, $s){
    echo "\n";echo __METHOD__;echo "\n";
    if((($ea == "%")||($ea == '.'))
      &&(!in_array($chor[2], (new AnaliseController)->naturais)
      &&($chor[2] != "%"))){//&&($chor[1] != " ") 3º analise
    //if(($ea == "%")){
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
    echo "\n";echo __METHOD__;echo "\n";
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
    echo "\n";echo __METHOD__;echo "\n";
    $s ++;
    $ac = $chor[$s];
    if(in_array($ac, $naturais)){ //talvez esteja errado
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
    echo "\n";echo __METHOD__;echo "\n";
    $numeros = ['2', '3', '4', '5', '6', '7', '9'];
    if((in_array($ac, $numeros))&&($cifra->dissonancia == "nao")){
      return AuxiliarController::numOk($cifra, $chor, $s);
    }else{
      return ['space', $chor, $ac, $s];;
    }
  }

  public static function numOk(CifraController $cifra, $chor, $s){
    echo "\n";echo __METHOD__;echo "\n";
      $cifra->dissonancia = "sim";
      return ['increm', $chor, $s]; //AnaliseController::increm($chor, $s);
  }

  public static function parentesis(CifraController $cifra, $chor, $ac, $s){
    echo "\n";echo __METHOD__;echo "\n";
    $s ++;
    $ac = $chor[$s];
    return AuxiliarController::seNum($cifra, $chor, $ac, $s);
  }

  public static function compostoIncompleto(CifraController $cifra)
  {
    echo "\n";echo __METHOD__;echo "\n";
    $cifra->composto = "sim"; 
  }

  public static function compostoCompleto(CifraController $cifra){
    echo "\n";echo __METHOD__;echo "\n";
    $cifra->composto = "nao";
    $cifra->dissonancia = "sim";
  }

  public static function seDim($chor, $s){
    echo "\n";echo __METHOD__;echo "\n";
    $dim = substr($chor, $s, 3); //espera receber a string ["d","i","m"]
    if($dim == "dim"){
      $s = ($s+2);
    }
    return [$chor, $s];
  }

  

  public static function seMarcado($arr, $chor, $s)
  {
    echo "\n";echo __METHOD__;echo "\n";
    $trecho = substr($chor, $s, 6);
    if(array_search($trecho, $arr)){
      $pular = array_keys($arr, $trecho);
      $chor = substr_replace($chor, $pular, $s, 6);
      echo "<br><br>ok suspenso: $chor<br><br>";
      $s = ($s + strlen($pular[0]) -1);
      echo "<br>s:..$s..e chor[0]:..$chor[0]..<br>";
    }
    echo "<br><br>suspenso: $chor<br><br>";

    return [$chor, $s];//correr o $s até o [-1] de $trecho.
  }

  public static function repor($chor, $s)
  {
    echo "\n";echo __METHOD__;echo "\n";
    $s ++;
    $trecho = substr($chor, $s, 2);
    if(($trecho == ("_1"))||($trecho == ("_2"))||($trecho == ("_3"))){
      $chor = substr_replace($chor, '', $s, 2);
      echo "<br><br>subs: $chor<br><br>";
    }
    return $chor;
  }
}
