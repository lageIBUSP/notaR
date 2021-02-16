<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TurmaController;
use App\Http\Controllers\NotaController;
use App\Http\Controllers\PrazoController;
use App\Http\Controllers\ExercicioController;
use App\Http\Controllers\TesteController;

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

require __DIR__.'/auth.php';
