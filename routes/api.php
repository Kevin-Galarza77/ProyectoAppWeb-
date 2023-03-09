<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Categorias\Aplication\ApiCategoriaController;
use App\Http\Controllers\Pedidos\Aplication\ApiCabeceraPedidosController;
use App\Http\Controllers\User\Controllers\ApiUserController;
use App\Http\Controllers\Usuarios\Controllers\ApiUsuarioController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Productos\Aplication\ApiProductoController;
use App\Http\Controllers\SubCategories\Aplication\ApiSubCategoriaController;

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

Route::post('login', [AuthController::class, 'login']);
Route::resource('register', ApiUsuarioController::class);
Route::post('password/forgot', 'App\Http\Controllers\Password\ForgotPasswordController@forgot');
Route::post('password/reset', 'App\Http\Controllers\Password\ResetPasswordController@reset');



Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::resource('usuarios',ApiUsuarioController::class);
    Route::resource('user',ApiUserController::class);
    Route::resource('categories',ApiCategoriaController::class);
    Route::resource('subcategories',ApiSubCategoriaController::class);
    Route::resource('products',ApiProductoController::class);
    Route::resource('pedidos',ApiCabeceraPedidosController::class);
    
});
