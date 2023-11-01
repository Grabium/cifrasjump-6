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

  public static function seEouA(TextoController $texto, $chor, $ac, $s){
    //if(($texto->texto[$texto->ea -1] == "%")&&(!in_array($chor[2], (new AnaliseController)->naturais))&&($chor[1] != " ")&&($chor[2] != "%")){
    if(($texto->texto[$texto->ea -1] == "%")){
      $chor = "*eanao*";//o if acima testa se a letra é início de frase.
      return ['increm', $chor]; //AnaliseController::increm($chor, $s);
    }else{
      $chor = substr($chor, 0, ($s));
      return ['positivo', $chor]; // encaminha para AnaliseController::positivo($chor);
    }
  }

  

  
}
