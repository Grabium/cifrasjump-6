<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PrincipalController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


//Route::get('/', [ColeAquiController::class, 'callPage_coleAqui']);
Route::post('/recebetexto', [PrincipalController::class, 'recebetexto'])->name('recebetexto');
/*Route::get('/recebetexto', function(){
    return ['msg'=>'teste do get ok!'];
});*/


/*
C#m7(5-) G#Maj7 Bm7M
Deixa acontecer naturalmente
DMaj7 G7M F#7M Bm7 Bbm7
Eu não quero ver você chorar
 Am7 D7(9) G7M F#7 Bm7
Deixa que  o amor encontre a gente
 D7(9) F#maj7 B
*/