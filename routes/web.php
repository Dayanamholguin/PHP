<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ambientesController;
use App\Http\Controllers\equiposController;
use App\Http\Controllers\reporteequiposController;

Route::get('/', [LandingController::class, 'index']);
Route::get('/inicio', [LandingController::class, 'index']);

Route::get('/home', [HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/ambiente', [ambientesController::class, 'index']);
Route::get('/ambiente/listar', [ambientesController::class, 'listar']);
Route::get('/ambiente/crear', [ambientesController::class, 'crear']);
Route::post('/ambiente/guardar', [ambientesController::class, 'guardar']);
Route::get('/ambiente/editar/{id}', [ambientesController::class, 'editar']);
Route::post('/ambiente/modificar', [ambientesController::class, 'modificar']);
Route::get('/ambiente/cambiarEstado/{id}/{estado}', [ambientesController::class, 'cambiarEstado']);

Route::get('/equipo', [equiposController::class, 'index']);
Route::get('/equipo/listar', [equiposController::class, 'listar']);
Route::get('/equipo/crear', [equiposController::class, 'crear']);
Route::post('/equipo/guardar', [equiposController::class, 'guardar']);
Route::get('/equipo/editar/{id}', [equiposController::class, 'editar']);
Route::post('/equipo/modificar', [equiposController::class, 'modificar']);
Route::get('/equipo/cambiarEstado/{id}/{estado}', [equiposController::class, 'cambiarEstado']);

Route::get('/reporte', [reporteequiposController::class, 'index']);
Route::post('/reporte/crear', [reporteequiposController::class, 'crear']);
Route::post('/reporte/guardar', [reporteequiposController::class, 'guardar']);
Route::get('/reporte/listar', [reporteequiposController::class, 'listar']);
Route::get('/reporte/cambiarEstado/{id}/{estado}', [reporteequiposController::class, 'cambiarEstado']);
Route::get('/reporte/pre_crear', [reporteequiposController::class, 'pre_crear']);
Route::get('/reporte/anulado', [reporteequiposController::class, 'indexAnulacion']);
Route::get('/reporte/listarAnulado', [reporteequiposController::class, 'listarAnulados']);
