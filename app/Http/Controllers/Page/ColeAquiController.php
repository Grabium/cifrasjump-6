<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ColeAquiController extends Controller
{
    public function callPage_coleAqui(){
      return view('/cole_aqui');
    }
}
