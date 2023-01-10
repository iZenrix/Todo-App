<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\TodoController;
use App\Models\Tugas;

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
    return view('welcome');
});

Route::get('/data', [TugasController::class, 'data'])->name('tugas.data');
Route::get('/todolist', [TugasController::class, 'index'])->name('tugas.index');
Route::post('/todolist', [TugasController::class, 'store'])->name('tugas.store');
Route::put('/todoliststatus/{id_tugas}', [TugasController::class, 'updateStatus'])->name('tugas.updateStatus');
// Route::put('/todolistactive/{id_tugas}', [TugasController::class, 'updateActive']);
// Route::put('/tes/{id_tugas}', function($id_tugas) {
//     $tugas = Tugas::findOrFail($id_tugas);
//     $tugas -> is_active = $tugas -> is_active == 1 ? 0 : 1;
//     $tugas -> save();

//     return response() -> json([
//         'statusActive' => 200
//     ]);
// });

Route::put('/todolist/{id_tugas}', [TugasController::class, 'update'])->name('tugas.update');
Route::delete('/todolist/{id_tugas}', [TugasController::class, 'destroy'])->name('tugas.delete');
Route::get('/todolist/{id_tugas}', [TugasController::class, 'show'])->name('tugas.show');

//Route::put('/todolistactive/{id_tugas}', [TugasController::class, 'update'])->name('tugas.update');


Route::resource('/Todo', TodoController::class);