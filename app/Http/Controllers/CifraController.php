<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CifraController extends Controller
{
  private int $semiTons;
  private $possivelInversao = 'nao';
  private $enarmonia = 'nao';
  private $invertido = 'nao' ;
  private $composto = "nao";
  private $sustOuBemol = "natural";
  private $sustOuBemolInv = "naturalInv";
  private $tomDaInversao = [];//array();
  private $dissonancia = "nao";
  private $terca = "nao testada";

  public function setSemiTons(int $semiTons)
  {
    $this->semiTons = $semiTons;
  }
  
  public function getSemiTons()
  {
    return $this->semiTons;
  }

  public function getPossivelInversao()
  {
    return $this->possivelInversao;
  }

  public function defaultPossivelInversao()
  {
    $this->possivelInvercao = 'nao' ;
    $this->invertido = 'nao' ;
  }

  public function getInvertido()
  {
    return $this->invertido;
  }

  function formataPositivo($chor)
    {
    $strl = strlen($chor);
    $fundamental = $chor[0];
    $tipo = substr($chor, 1);
    if($this->possivelInversao == 'nao'){
      $fundamental = $chor[0];
      $tipo = substr($chor, 1);//restante do acorde natural
      //echo "<br />não acidente.";
    }else{
      $fundamental = substr($chor, 0, 2);
      $tipo = substr($chor, 2);//restante do acorde enarmônico
      //echo "<br />sim acidente.";
    }
    return [$fundamental, $tipo];
    }

  public function setCifraDefault($positivo){
    //$conversor->converter($positivo, $conversor);
    $this->enarmonia = 'nao';
    $this->composto = "nao";
    $this->invertido = "nao";
    $this->sustOuBemol = "natural";
    $this->sustOuBemolInv = "naturalInv";
    $this->tomDaInversao = [];//array();
    $this->dissonancia = "nao";
    $this->terca = "nao testada";
  }
}
