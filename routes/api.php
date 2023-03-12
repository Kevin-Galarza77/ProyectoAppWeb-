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

    Route::get('categories','App\Http\Controllers\Categorias\Aplication\ApiCategoriaController@index');
    Route::get('categories/{id}','App\Http\Controllers\Categorias\Aplication\ApiCategoriaController@show');
    Route::post('categories','App\Http\Controllers\Categorias\Controllers\CreateCategoriaController@store');
    Route::post('categories/{id}','App\Http\Controllers\Categorias\Controllers\UpdateCategoriaController@update');
    Route::delete('categories/{id}','App\Http\Controllers\Categorias\Aplication\ApiCategoriaController@destroy');

    Route::get('subcategories','App\Http\Controllers\SubCategories\Aplication\ApiSubCategoriaController@index');
    Route::get('subcategories/{id}','App\Http\Controllers\SubCategories\Aplication\ApiSubCategoriaController@show');
    Route::post('subcategories','App\Http\Controllers\SubCategories\Controllers\CreateSubCategoriaController@store');
    Route::post('subcategories/{id}','App\Http\Controllers\SubCategories\Controllers\UpdateSubCategoriaController@update');
    Route::delete('subcategories/{id}','App\Http\Controllers\SubCategories\Aplication\ApiSubCategoriaController@destroy');

    Route::get('products','App\Http\Controllers\Productos\Aplication\ApiProductoController@index');
    Route::get('products/{id}','App\Http\Controllers\Productos\Aplication\ApiProductoController@show');
    Route::post('products','App\Http\Controllers\Productos\Controllers\CreateProductoController@store');
    Route::post('products/{id}','App\Http\Controllers\Productos\Controllers\UpdateProductoController@update');
    Route::delete('products/{id}','App\Http\Controllers\Productos\Aplication\ApiProductoController@destroy');

    Route::resource('pedidos',ApiCabeceraPedidosController::class);
});
