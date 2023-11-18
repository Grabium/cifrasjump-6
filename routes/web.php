<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Page\ColeAquiController;
use App\Http\Controllers\PrincipalController;



Route::get('/', [ColeAquiController::class, 'callPage_coleAqui']);
Route::post('/recebetexto', [PrincipalController::class, 'recebetexto'])->name('recebetexto');

/*
C#m7(5-) G#Maj7 Bm7M
Deixa acontecer naturalmente
DMaj7 G7M F#7M Bm7 Bbm7
Eu não quero ver você chorar
 Am7 D7(9) G7M F#7 Bm7
Deixa que  o amor encontre a gente
 D7(9) F#maj7 B
*/