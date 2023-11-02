<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuxiliarController extends Controller
{
  function endString($chor){
    $l = strlen($chor);
    if($l == 1){
      return "positivo"; //último caractere dentro de naturais. É um acorde. 
    }else{
      $chor = $chor . " ";
      return $chor;
    }
  }

  public static function seEouA(TextoController $texto, $chor, $s){
    //if(($texto->texto[$texto->ea -1] == "%")&&(!in_array($chor[2], (new AnaliseController)->naturais))&&($chor[1] != " ")&&($chor[2] != "%")){
    if(($texto->texto[$texto->ea -1] == "%")){
      $chor = "*eanao*";//o if acima testa se a letra é início de frase.
      return ['increm', $chor, $s]; //AnaliseController::increm($chor, $s);
    }else{
      $chor = substr($chor, 0, ($s));
      return ['positivo', $chor]; // encaminha para AnaliseController::positivo($chor);
    }
  }

  public static function processaSustenidoEBemol(CifraController $cifra, $s, $ac)
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

  public static function bar(CifraController $cifra, $chor, $ac, $s)
  {
    echo "passou barra";
    $s ++;
    $ac = $chor[$s];
    //echo gettype($ac);// fim de teste
    if(in_array($ac, $analise->naturais)){ //talvez esteja errado
      $cifra->possivelInvercao = 'sim';
      $s ++;
      $ac = $chor[$s];
      if($ac == " "){
        $cifra->tomDaInversao = $chor[$s-1];//array($s - 1, 1);
        $cifra->invertido = 'sim';
        $cifra->sustOuBemolInv = "naturalInv";
        ECHO "<br /><br /><br /><br /><br />Inversão sus ou bem de ".$chor." analiz:".$ac." : ".$cifra->sustOuBemolInv."<br />";
        return ['space', $chor, $ac, $s];//AnaliseController::space($chor, $ac, $s);
      }elseif(($ac == '#')||($ac == 'b')){
        if($ac == '#'){
          $cifra->sustOuBemolInv = "sustenidoInv";
        }elseif($ac == 'b'){
          $cifra->sustOuBemolInv = "bemolInv";
        }
        ECHO "<br /><br /><br /><br /><br />Inversão sus ou bem de ".$chor." analiz:".$ac." : ".$cifra->sustOuBemolInv."<br />";
        $s ++;
        $ac = $chor[$s];
        if($ac == " "){
          $cifra->tomDaInversao = $chor[$s-2].$chor[$s-1];//array($s - 2, 2);
          $cifra->invertido = 'sim';
          return ['space', $chor, $ac, $s];//AnaliseController::space($chor, $ac, $s);
        }
      }else{
        return AuxiliarController::seNum($chor, $ac, $s);
      }
    }else{
      return AuxiliarController::seNum($chor, $ac, $s);
    }//bloco do if(in_array...
  }//bar()

  function seNum($chor, $ac, $s){
    if((in_array($ac, $cifra->numeros))&&($cifra->dissonancia == "nao")){
      return AuxiliarController::numOk($chor, $s);
    }else{
      return ['space', $chor, $ac, $s];;
    }
  }

  function numOk($chor, $s){
      $cifra->dissonancia = "sim";
      return ['increm', $chor, $s]; //AnaliseController::increm($chor, $s);
  }

  public static function parentesis(CifraController $cifra, $chor, $ac, $s){
    $analise->parentesis = "aberto";
    $s ++;
    $ac = $chor[$s];
    return AuxiliarController::seNum($chor, $ac, $s);
  }
}
