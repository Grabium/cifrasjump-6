<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TextoController extends Controller
{
  public string $texto;
  public int $ea; //onde foi encontrado um "E" ou "A".
  
  //   < entrada_do_cliente > => < novo_valor >
  public $agenteCli = [ "\r\n" => ' % '];

  //diminuto
  public $dimCli = [
    '°'    => '|_d000',
    'º'    => '|_d001',
    'dim'  => '|_d002'];                        
  
  //maj
  public $majCli = [
    'Maj7' => '|_m000', 
    'maj7' => '|_m001',
    '7M'   => '|_m002'];
  
  //suspenso
  public $susCli = [
    'sus2'  => '|_s000',
    'sus9'  => '|_s001',
    'sus4'  => '|_s002',
    'sus11' => '|_s003'];

  //adicionado
  public $addCli = [
    'add4'   => '|_a000',
    'add11'  => '|_a001',
    'add2'   => '|_a002',
    'add9'   => '|_a003'];

  //aumentado (adicionado com outra grafia)
  public $augCli = [
    'aug2'   => '|_g000',
    'aug9'   => '|_g001',
    'aug4'   => '|_g002',
    'sus11'  => '|_g003'];
  
  /*
  //recebem as chaves que serão formatadas
  public $agenteCliKeys = [];
  public $dimCliKeys    = [];
  public $majCliKeys    = [];
  public $susCliKeys    = [];
  public $addCliKeys    = [];
  public $augCliKeys    = [];
  */

  public function setTexto(string $texto)
  {
    $nova = array_merge( //atenção à ordem.
      $this->agenteCli, 
      $this->dimCli, 
      $this->majCli, 
      $this->susCli,
      $this->addCli,
      $this->augCli
    );
    
    $original = array_merge( //atenção à ordem.
      array_keys($this->agenteCli),
      array_keys(   $this->dimCli),
      array_keys(   $this->majCli),
      array_keys(   $this->susCli),
      array_keys(   $this->addCli),
      array_keys(   $this->augCli)
    );

    /*
    $this->agenteCliKeys = array_keys($this->agenteCli);
    $this->dimCliKeys    = array_keys($this->dimCli);
    $this->majCliKeys    = array_keys($this->majCli);
    $this->susCliKeys    = array_keys($this->susCli);
    $this->addCliKeys    = array_keys($this->addCli);
    $this->augCliKeys    = array_keys($this->augCli);
    */
    
    //$this->texto = str_replace(array_de_chaves, array_de_valores,  $texto); ATENÇÃO À ORDEM!
    $this->texto = str_replace( $original, $nova, $texto); 
  }

  public function getTexto()
  {
    return $this->texto;
  }

  public function setEA($i)
  {
    $this->ea = $i;
  }

  
}
