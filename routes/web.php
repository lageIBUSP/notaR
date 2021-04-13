<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TurmaController;
use App\Http\Controllers\NotaController;
use App\Http\Controllers\PrazoController;
use App\Http\Controllers\ExercicioController;
use App\Http\Controllers\TesteController;

// Use APP_URL by default
URL::forceRootUrl(env('APP_URL'));
// For use of https
URL::forceScheme(env('APP_SCHEME', 'http'));

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    return view('home');
});

Route::resources([
    'user' => UserController::class,
    'turma' => TurmaController::class,
    'teste' => TesteController::class,
    'exercicio' => ExercicioController::class,
    'prazo' => PrazoController::class,
    'nota' => NotaController::class,
]);

Route::get('/turma/{turma}/remove/{user}', [TurmaController::class, 'remove']);
Route::get('/turma/{turma}/prazos', [TurmaController::class, 'editprazos']);
Route::put('/turma/{turma}/prazos', [TurmaController::class, 'updateprazos']);
Route::post('/exercicio/{exercicio}', [ExercicioController::class, 'submit'])->name('exercicio.submit');

require __DIR__.'/auth.php';

Route::post('/image/upload', 'ImageController@upload')->name('image.upload');