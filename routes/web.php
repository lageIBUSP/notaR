<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TurmaController;
use App\Http\Controllers\PrazoController;
use App\Http\Controllers\ExercicioController;
use App\Http\Controllers\ArquivoController;
use App\Http\Controllers\ImpedimentoController;
use App\Http\Controllers\RelatorioController;

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

Route::get('/relatorio', [RelatorioController::class, 'index']);


Route::get('/turma/{turma}/remove/{user}', [TurmaController::class, 'remove']);
Route::get('/turma/{turma}/prazos', [TurmaController::class, 'editprazos']);
Route::put('/turma/{turma}/prazos', [TurmaController::class, 'updateprazos']);

Route::put('/exercicio/import', [ExercicioController::class, 'import'])->name('exercicio.import');
Route::get('/exercicio/exportall', [ExercicioController::class, 'exportall']);
Route::post('/exercicio/{exercicio}', [ExercicioController::class, 'submit'])->name('exercicio.submit');
Route::post('/exercicio/{exercicio}/upload', [ExercicioController::class, 'upload'])->name('exercicio.upload');
Route::get('/exercicio/{exercicio}/export', [ExercicioController::class, 'export'])->name('exercicio.export');
Route::put('/exercicio/{exercicio}/import', [ExercicioController::class, 'importEdit']);

Route::resources([
    'user' => UserController::class,
    'turma' => TurmaController::class,
    'exercicio' => ExercicioController::class,
    'prazo' => PrazoController::class,
    'arquivo' => ArquivoController::class,
    'impedimento' => ImpedimentoController::class,
]);
require __DIR__.'/auth.php';
