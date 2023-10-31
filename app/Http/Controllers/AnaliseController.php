<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnaliseController extends Controller
{
    public $naturais = ['C','D','E','F','G','A','B'];
    private $cifra;

    function __construct()
    {
        //
    }

    function analizar1(CifraController $cifra, $chor){
      $this->cifra = $cifra;
      $s = 1;
      AnaliseController::space($chor, $chor[1], $s);
    }
}
