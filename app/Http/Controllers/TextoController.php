<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TextoController extends Controller
{
  public string $texto;
  public int $ea; //onde foi encontrado um "E" ou "A".
  
  //   < entrada_do_cliente > => < novo_valor >
  public $agenteCli = [ "\r\n" => ' % ',
                        '°' => 'dim',
                        'º' => 'dim'];
  
  //maj
  public $majCli = ['Maj7'=>'7+_1', 
                    'maj7'=>'7+_2',
                    '7M'=>'7+_3'];
  
  //suspenso
  public $susCli = ['sus2'=>'sus02_4',
                    'sus9'=>'sus09_5',
                    'sus4'=>'sus04_6',
                    'sus11'=>'sus11_7'];

  //recebem as chaves que serão formatadas
  public $agenteCliKeys = [];
  public $majCliKeys = [];
  public $susCliKeys = [];

  public function setTexto(string $texto)
  {
    
    $this->agenteCliKeys = array_keys($this->agenteCli);
    $this->majCliKeys = array_keys($this->majCli);
    $this->susCliKeys = array_keys($this->susCli);
    
    //$this->texto = str_replace(  $texto); 
    $this->texto = str_replace( array_merge($this->agenteCliKeys, $this->majCliKeys, $this->susCliKeys), 
                                array_merge($this->agenteCli, $this->majCli, $this->susCli),
                                $texto); 
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
