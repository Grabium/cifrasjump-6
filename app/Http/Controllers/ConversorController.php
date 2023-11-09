<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConversorController extends Controller
{
  private $tonalidadeSustenido = ['C', 'C#', 'D', 'D#', 'E', 'F', 'F#', 'G', 'G#', 'A', 'A#', 'B'];
  private $tonalidadeBemol = ['C', 'Db', 'D', 'Eb', 'E', 'F', 'Gb', 'G', 'Ab', 'A', 'Bb', 'B'];
  private int $semiTons;


  public function setSemiTons(int $semiTons)
  {
    $this->semiTons = $semiTons;
  }
  
  public function conversor(CifraController $cifra){
    $fundamental = $cifra->guardaCifras[0];
    $tipo = $cifra->guardaCifras[1];
    $cifra->guardaCifras = [];

    $key = 0;
    if($cifra->sustOuBemol == "sustenido"){
      $key = array_search($fundamental, $this->tonalidadeSustenido);//retorna o número da fundamental caso sustenido.
    }elseif(($cifra->sustOuBemol == "bemol")||($cifra->sustOuBemol == "natural")){
      $key = array_search($fundamental, $this->tonalidadeBemol);//retorna o número da fundamental caso bemol ou natural.
    }
    $resto = (($this->semiTons + $key)%12);
    $n = ConversorController::calcularConv($resto); //$this->tonalidadeSustenido[$resto];
    if($cifra->invertido == "sim"){
      $tomInv = $cifra->tomDaInversao;
      if($cifra->sustOuBemolInv == "sustenidoInv"){
        $keyInv = array_search($cifra->tomDaInversao, $this->tonalidadeSustenido);//retorna o número da fundamental caso sustenido.
      }else{
        $keyInv = array_search($cifra->tomDaInversao, $this->tonalidadeBemol);//retorna o número da fundamental caso bemol.
      }
      $restoInv = (($this->semiTons + $keyInv)%12);
      $nInv = ConversorController::calcularConv($restoInv); //$this->tonalidadeSustenido[$restoInv];
      $tipo = str_replace($tomInv, $nInv, $tipo);
    }
    $nChord = $n . $tipo;
    echo "<br /><font color='red'>Convertido para: $nChord</font><br />";
  }

  function calcularConv($rst){
    if($rst < 0){
      $rr = $this->tonalidadeSustenido[12 + $rst];
    }else{
      $rr = $this->tonalidadeSustenido[$rst];
    }
    return $rr;
  }
}