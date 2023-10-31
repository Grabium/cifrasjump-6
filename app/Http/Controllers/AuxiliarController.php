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
}
