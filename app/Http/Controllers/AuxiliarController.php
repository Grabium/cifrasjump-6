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
    //echo "<br>texto: $texto->texto;<br>ea: $texto->ea;<br>chor: $chor";
    //var_dump(in_array("F", (new AnaliseController)->naturais)); 
    if(($texto->texto[$texto->ea -1] == "%")&&(!in_array($chor[2], (new AnaliseController)->naturais))&&($chor[1] != " ")&&($chor[2] != "%")){
      $chor = "*eanao*";
      //Echo"<br/>ponto b =$chor.";
      return ['increm', $chor]; //AnaliseController::increm($chor, $ac, $s);
    }else{
      $chor = substr($chor, 0, ($s));
      //Echo"<br/>ponto c =$ac.";
      return ['positivo', $chor]; // encaminha para AnaliseController::positivo($chor);
    }
  }

  

  
}
