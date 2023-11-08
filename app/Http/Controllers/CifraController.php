<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CifraController extends Controller
{
  
  public $possivelInversao = 'nao';
  public $enarmonia = 'nao';
  public $invertido = 'nao' ;
  public $composto = "nao";
  public $sustOuBemol = "natural";
  public $sustOuBemolInv = "naturalInv";
  public $tomDaInversao = "";
  public $dissonancia = "nao";
  public $terca = "nao testada";
  public $guardaCifras = [];

  
  
  public function getSemiTons()
  {
    return $this->semiTons;
  }

  
  public function defaultPossivelInversao()
  {
    $this->possivelInversao = 'nao' ;
    $this->invertido = 'nao' ;
  }
  

  public function guardarCifras($positivo)
  {
    $this->guardaCifras = [$positivo[0], $positivo[1]];
  }

  function formataPositivo($chor)
  {
    if($this->enarmonia == 'nao'){
      $fundamental = $chor[0];
      $tipo = substr($chor, 1);//restante do acorde natural
    }elseif($this->enarmonia == 'sim'){
      $fundamental = substr($chor, 0, 2);
      $tipo = substr($chor, 2);//restante do acorde enarmônico
    }
    return [$fundamental, $tipo];
  }

  public function setCifraDefault(){
    $this->possivelInversao = 'nao';
    $this->enarmonia = 'nao';
    $this->composto = "nao";
    $this->invertido = "nao";
    $this->sustOuBemol = "natural";
    $this->sustOuBemolInv = "naturalInv";
    $this->tomDaInversao = "";//array();
    $this->dissonancia = "nao";
    $this->terca = "nao testada";
    echo "<br>";
    
  }
}
