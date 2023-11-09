<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Page\ColeAquiController;
use App\Http\Controllers\PrincipalController;



Route::get('/', [ColeAquiController::class, 'callPage_coleAqui']);
Route::post('/recebetexto', [PrincipalController::class, 'recebetexto'])->name('recebetexto');

/*
  Gsus4  C#m7(5-) F#Maj7  Bm7M
Deixa acontecer naturalmente
D7(9)         G7M   F#7   Bm7  Bbm7
Eu não quero ver você chorar
 Am7    D7(9)  G7M   F#7      Bm7
Deixa que  o amor encontre a gente
 D7(9)        F#7(13-)  Bm7  
Nosso caso vai      etern_____izar
*/