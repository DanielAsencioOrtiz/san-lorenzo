<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MovilController;
use App\Http\Controllers\TipoConcretoController;
use App\Http\Controllers\MetodoColocacionController;
use App\Http\Controllers\BombaController;
use App\Http\Controllers\TipoCementoController;
use App\Http\Controllers\EstructuraController;
use App\Http\Controllers\ObraController;
use App\Http\Controllers\ResistenciaController;
use App\Http\Controllers\SlamController;
use App\Http\Controllers\TipoPersonalController;
use App\Http\Controllers\SedeController;
use App\Http\Controllers\TipoDocumentoController;
use App\Http\Controllers\PersonalController;
use App\Http\Controllers\PiedraController;
use App\Http\Controllers\ClienteController;

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
Route::get('/tipo_concretos-restore/{id}', [TipoConcretoController::class, 'restore'])->name('tipo_concretos.restore');

//METODO COLOCACION
Route::get('/metodo_colocacions', [MetodoColocacionController::class, 'index'])->name('metodo_colocacions.index');
Route::post('/metodo_colocacions', [MetodoColocacionController::class, 'store'])->name('metodo_colocacions.store');
Route::post('/metodo_colocacions/{id}', [MetodoColocacionController::class, 'update'])->name('metodo_colocacions.update');
Route::get('/metodo_colocacions-delete/{id}', [MetodoColocacionController::class, 'destroy'])->name('metodo_colocacions.destroy');
Route::get('/metodo_colocacions-restore/{id}', [MetodoColocacionController::class, 'restore'])->name('metodo_colocacions.restore');

//BOMBAS

Route::get('/bombas', [BombaController::class, 'index'])->name('bombas.index');
Route::post('/bombas', [BombaController::class, 'store'])->name('bombas.store');
Route::post('/bombas/{id}', [BombaController::class, 'update'])->name('bombas.update');
Route::get('/bombas-delete/{id}', [BombaController::class, 'destroy'])->name('bombas.destroy');
Route::get('/bombas-restore/{id}', [BombaController::class, 'restore'])->name('bombas.restore');

//TIPO DE CEMENTO
Route::get('/tipo_cementos', [TipoCementoController::class, 'index'])->name('tipo_cementos.index');
Route::post('/tipo_cementos', [TipoCementoController::class, 'store'])->name('tipo_cementos.store');
Route::post('/tipo_cementos/{id}', [TipoCementoController::class, 'update'])->name('tipo_cementos.update');
Route::get('/tipo_cementos-delete/{id}', [TipoCementoController::class, 'destroy'])->name('tipo_cementos.destroy');
Route::get('/tipo_cementos-restore/{id}', [TipoCementoController::class, 'restore'])->name('tipo_cementos.restore');

//ESTRUCTURAS
Route::get('/estructuras', [EstructuraController::class, 'index'])->name('estructuras.index');
Route::post('/estructuras', [EstructuraController::class, 'store'])->name('estructuras.store');
Route::post('/estructuras/{id}', [EstructuraController::class, 'update'])->name('estructuras.update');
Route::get('/estructuras-delete/{id}', [EstructuraController::class, 'destroy'])->name('estructuras.destroy');
Route::get('/estructuras-restore/{id}', [EstructuraController::class, 'restore'])->name('estructuras.restore');

//OBRAS
Route::get('/obras', [ObraController::class, 'index'])->name('obras.index');
Route::post('/obras', [ObraController::class, 'store'])->name('obras.store');
Route::post('/obras/{id}', [ObraController::class, 'update'])->name('obras.update');
Route::get('/obras-delete/{id}', [ObraController::class, 'destroy'])->name('obras.destroy');
Route::get('/obras-restore/{id}', [ObraController::class, 'restore'])->name('obras.restore');

//RESISTENCIAS
Route::get('/resistencias', [ResistenciaController::class, 'index'])->name('resistencias.index');
Route::post('/resistencias', [ResistenciaController::class, 'store'])->name('resistencias.store');
Route::post('/resistencias/{id}', [ResistenciaController::class, 'update'])->name('resistencias.update');
Route::get('/resistencias-delete/{id}', [ResistenciaController::class, 'destroy'])->name('resistencias.destroy');
Route::get('/resistencias-restore/{id}', [ResistenciaController::class, 'restore'])->name('resistencias.restore');

//SLAMS
Route::get('/slams', [SlamController::class, 'index'])->name('slams.index');
Route::post('/slams', [SlamController::class, 'store'])->name('slams.store');
Route::post('/slams/{id}', [SlamController::class, 'update'])->name('slams.update');
Route::get('/slams-delete/{id}', [SlamController::class, 'destroy'])->name('slams.destroy');
Route::get('/slams-restore/{id}', [SlamController::class, 'restore'])->name('slams.restore');

//TIPO PERSONAL
Route::get('/tipo-personal', [TipoPersonalController::class, 'index'])->name('tipo-personal.index');
Route::post('/tipo-personal', [TipoPersonalController::class, 'store'])->name('tipo-personal.store');
Route::post('/tipo-personal/{id}', [TipoPersonalController::class, 'update'])->name('tipo-personal.update');
Route::get('/tipo-personal-delete/{id}', [TipoPersonalController::class, 'destroy']);
Route::get('/tipo-personal-restore/{id}', [TipoPersonalController::class, 'restore']);

//SEDE
Route::get('/sede', [SedeController::class, 'index'])->name('sede.index');
Route::post('/sede', [SedeController::class, 'store'])->name('sede.store');
Route::post('/sede/{id}', [SedeController::class, 'update'])->name('sede.update');
Route::get('/sede-delete/{id}', [SedeController::class, 'destroy']);
Route::get('/sede-restore/{id}', [SedeController::class, 'restore']);

//TIPO DOCUMENTO
Route::get('/tipo-documento', [TipoDocumentoController::class, 'index'])->name('tipo-documento.index');
Route::post('/tipo-documento', [TipoDocumentoController::class, 'store'])->name('tipo-documento.store');
Route::post('/tipo-documento/{id}', [TipoDocumentoController::class, 'update'])->name('tipo-documento.update');
Route::get('/tipo-documento-delete/{id}', [TipoDocumentoController::class, 'destroy']);
Route::get('/tipo-documento-restore/{id}', [TipoDocumentoController::class, 'restore']);

//PERSONAL
Route::get('/personal', [PersonalController::class, 'index'])->name('personal.index');
Route::post('/personal', [PersonalController::class, 'store'])->name('personal.store');
Route::post('/personal/{id}', [PersonalController::class, 'update'])->name('personal.update');
Route::get('/personal-delete/{id}', [PersonalController::class, 'destroy']);
Route::get('/personal-restore/{id}', [PersonalController::class, 'restore']);

//PIEDRAS
Route::get('/piedras', [PiedraController::class, 'index'])->name('piedras.index');
Route::post('/piedras', [PiedraController::class, 'store'])->name('piedras.store');
Route::post('/piedras/{id}', [PiedraController::class, 'update'])->name('piedras.update');
Route::get('/piedras-delete/{id}', [PiedraController::class, 'destroy']);
Route::get('/piedras-restore/{id}', [PiedraController::class, 'restore']);


//CLIENTES
Route::get('/clientes', [ClienteController::class, 'index'])->name('clientes.index');
Route::post('/clientes', [ClienteController::class, 'store'])->name('clientes.store');
Route::post('/clientes/{id}', [ClienteController::class, 'update'])->name('clientes.update');
Route::get('/clientes-delete/{id}', [ClienteController::class, 'destroy'])->name('clientes.destroy');
Route::get('/clientes-restore/{id}', [ClienteController::class, 'restore'])->name('clientes.restore');

// Selects dinámicos (AJAX)
Route::get('/clientes/provincias/{id_departamento}', [ClienteController::class, 'getProvincias'])->name('clientes.provincias');
Route::get('/clientes/distritos/{id_provincia}', [ClienteController::class, 'getDistritos'])->name('clientes.distritos');
Route::get('/consulta-documento/{tipo}/{numero}', [ClienteController::class, 'consultaDocumento']);


Route::post('/permissions', [PermissionController::class, 'store'])->middleware('auth');
