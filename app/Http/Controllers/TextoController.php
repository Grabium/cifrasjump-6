<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TextoController extends Controller
{
  public string $texto;
  public int $ea; //onde foi encontrado um "E" ou "A".

  public function setTexto(string $texto)
  {
    $this->texto = str_replace(["\r\n","°","º"], [" % ","dim","dim"], $texto); 
    $this->texto = str_replace(["Maj7","maj7","7M"], ["7+_1","7+_2","7+_3"], $this->texto); 
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
