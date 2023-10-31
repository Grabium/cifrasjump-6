<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TextoController extends Controller
{
    private string $texto;

    public function setTexto(string $texto)
    {
        $this->texto = str_replace(["\r\n","°","º"], [" %","dim","dim"], $texto);
    }

    public function getTexto()
    {
        return $this->texto;
    }
}
