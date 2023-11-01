<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CifraController extends Controller
{
    private int $semiTons;
    private $possivelInversao = 'nao';
    private $enarmonia = 'nao';
    private $invertido = 'nao' ;

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
}
