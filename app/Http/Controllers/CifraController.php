<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CifraController extends Controller
{
  private int $semiTons; 
  public $possivelInversao = 'nao';
  public $enarmonia = 'nao';
  public $invertido = 'nao' ;
  public $composto = "nao";
  public $sustOuBemol = "natural";
  public $sustOuBemolInv = "naturalInv";
  public $tomDaInversao = [];//array();
  public $dissonancia = "nao";
  public $terca = "nao testada";
  public $guardaCifras = [];

  public function setSemiTons(int $semiTons)
  {
    $this->semiTons = $semiTons;
  }
  
  public function getSemiTons()
  {
    return $this->semiTons;
  }

  public function defaultPossivelInversao()
  {
    $this->possivelInversao = 'nao' ;
    $this->invertido = 'nao' ;
  }

  public function guardarCifras($chor)
  {
    array_push($this->guardaCifras, $chor);
  }

  /*
  function formataPositivo($chor)
  {
    
    $strl = strlen($chor);
    $fundamental = $chor[0];
    $tipo = substr($chor, 1);
    if($this->enarmonia == 'nao'){
      $fundamental = $chor[0];
      $tipo = substr($chor, 1);//restante do acorde natural
      //echo "<br />não acidente.";
    }elseif($this->enarmonia == 'sim'){
      $fundamental = substr($chor, 0, 2);
      $tipo = substr($chor, 2);//restante do acorde enarmônico
      //echo "<br />sim acidente.";
    }
    return [$fundamental, $tipo];
  }*/

  public function setCifraDefault($chor){
    //$conversor->converter($positivo, $conversor);
    $this->possivelInversao = 'nao';
    $this->enarmonia = 'nao';
    $this->composto = "nao";
    $this->invertido = "nao";
    $this->sustOuBemol = "natural";
    $this->sustOuBemolInv = "naturalInv";
    $this->tomDaInversao = [];//array();
    $this->dissonancia = "nao";
    $this->terca = "nao testada";
    echo "<br>";
    print_r($this->guardaCifras);
  }
}
