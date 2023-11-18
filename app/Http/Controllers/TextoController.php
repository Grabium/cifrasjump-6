<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TextoController extends Controller
{
  public string $texto;
  public int $ea; //onde foi encontrado um "E" ou "A".
  private string $textoConvertido = '';
  public int $pularCaracteres = -10;
  
  private $locaLen = []; //guarda local $i e tamanho de chor a ser analisado
  private $marcadores = [];
  private $original = [];
    
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
  

  public function setTexto(string $texto)
  {
    $this->marcadores = array_merge( //atenção à ordem.
      $this->dimCli, 
      $this->majCli, 
      $this->susCli,
      $this->addCli,
      $this->augCli
    );
    
    $this->original = array_merge( //atenção à ordem.
      array_keys(   $this->dimCli),
      array_keys(   $this->majCli),
      array_keys(   $this->susCli),
      array_keys(   $this->addCli),
      array_keys(   $this->augCli)
    );

    $this->texto = str_replace( array_merge(array_keys($this->agenteCli), $this->original), array_merge($this->agenteCli, $this->marcadores), $texto); 
  }

  public function getTexto()
  {
    return $this->texto;
  }

  public function setEA($i)
  {
    $this->ea = $i;
  }

  

  public function concatConvertido(array $par)
  {
    
    /*TESTE*/$l = strlen($this->texto);echo '<br>'.$l.'=lenght.';print_r($par);
    
    $nChord = $par[1];
    $espaco = $par[2];
    $this->textoConvertido = $this->textoConvertido . $espaco . $nChord ;
    echo "<br><strong>concatena convertido:..$this->textoConvertido..</strong>";
  }

  public function concatITexto(array $par)
  {
    echo '<br>';print_r($par);
    $caractere = $this->texto[$par[0]];
    $espaco = $par[1];
    $this->textoConvertido = $this->textoConvertido . $espaco . $caractere ;
    //echo "<br><strong>concatena i de texto:..$this->textoConvertido..</strong>";
  }

  public function getTextoConvertido()
  {
    //$this->textoConvertido = str_replace(  '%', '\r\n', $this->textoConvertido);
    $this->textoConvertido = str_replace( $this->marcadores, $this->original, $this->textoConvertido);
    return $this->textoConvertido;
  }
  
}
