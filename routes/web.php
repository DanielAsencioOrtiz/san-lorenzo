<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MovilController;
use App\Http\Controllers\TipoConcretoController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', function () {
    return Auth::check() ? redirect('/home') : redirect('/login');
});

Auth::routes();
Route::post('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
    Route::post('/roles/{id}/permissions', [RoleController::class, 'assignPermissions'])->name('roles.assignPermissions');
    Route::delete('/roles/{id}', [RoleController::class, 'destroy'])->name('roles.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios.index');
    Route::post('/usuarios', [UserController::class, 'store'])->name('usuarios.store');
    Route::post('/usuarios/{id}', [UserController::class, 'update'])->name('usuarios.update');
    Route::get('/usuarios-delete/{id}', [UserController::class, 'destroy'])->name('usuarios.destroy');
});

//MOVILES
Route::get('/movils', [MovilController::class, 'index'])->name('movil.index');
Route::post('/movils', [MovilController::class, 'store'])->name('movil.store');
Route::post('/movils/{id}', [MovilController::class, 'update'])->name('movil.update');
Route::get('/movils-delete/{id}', [MovilController::class, 'destroy'])->name('movil.delete');
Route::get('/movils-restore/{id}', [MovilController::class, 'restore'])->name('movil.restore');


//TIPO CONCRETOS
Route::get('/tipo_concretos', [TipoConcretoController::class, 'index'])->name('tipo_concretos.index');
Route::post('/tipo_concretos', [TipoConcretoController::class, 'store'])->name('tipo_concretos.store');
Route::post('/tipo_concretos/{id}', [TipoConcretoController::class, 'update'])->name('tipo_concretos.update');
Route::get('/tipo_concretos-delete/{id}', [TipoConcretoController::class, 'destroy'])->name('tipo_concretos.delete');


Route::post('/permissions', [PermissionController::class, 'store'])->middleware('auth');
