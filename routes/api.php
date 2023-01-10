<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UsuariosController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
git remote add origin https://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@github.com/edgarmm97/api-taxi.git
*/

Route::prefix('usuario')->group(function () {

    Route::post('/create', [UsuariosController::class, 'storage']);

    Route::delete('/delete', [UsuariosController::class, 'destroy'])->middleware('jwt');

});

Route::prefix('autenticacion')->group(function(){

    Route::post('/usuario/login', [UsuariosController::class, 'login']);

});

