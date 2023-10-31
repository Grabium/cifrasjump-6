<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Page\ColeAquiController;
use App\Http\Controllers\PrincipalController;



Route::get('/', [ColeAquiController::class, 'callPage_coleAqui']);
Route::post('/recebetexto', [PrincipalController::class, 'recebetexto'])->name('recebetexto');