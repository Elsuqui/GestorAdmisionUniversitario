<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Auth::routes();
Route::post("/ingresar", "Auth\LoginController@ingresar")->name("ingresar");
Route::get("/not-found", function (){
   return view("layouts.404");
});

// Grupo de Rutas para
Route::middleware(["web", "auth"])->group(function (){
    Route::get('/home', 'HomeController@index')->name('home');
    Route::post("/salir", "Auth\LoginController@logout")->name("salir");
    // Rutas para los contenedores principales de módulos
    /*Route::get("/{any}")
        ->where("any", "^(?!login|ingresar|register|salir)$");*/
   Route::get("/{any}", "HomeController@index")
       ->where("any", ".*")
       ->where("any", "^(?!api).*$");
});




