<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestServiceLayerController;
use App\Http\Controllers\TestServiceLayerMacroController;
use App\Http\Controllers\TipoDeCambioController;
use App\Http\Controllers\TipoDeCambioEuroController;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [TestServiceLayerController::class, 'login']);
Route::get('/providers', [TestServiceLayerController::class, 'getProviders']);
Route::get('/login-macro', [TestServiceLayerMacroController::class, 'loginMacro']);
Route::get('/providers-macro', [TestServiceLayerMacroController::class, 'getProvidersMacro']);
Route::get('/logout', [TestServiceLayerController::class, 'logout']); 
Route::get('/logout-macro', [TestServiceLayerMacroController::class, 'logoutMacro']); 
Route::get('/tipodecambio_actual', [TipoDeCambioController::class, 'obtenerTipoDeCambioActual']);
Route::get('/tipodecambio_euro', [TipoDeCambioEuroController::class, 'obtenerTipoDeCambioActual']);




