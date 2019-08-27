<?php
use Illuminate\Support\Facades\Route;

Route::get("busqueda", "PersonaController@busqueda")->name("buscar.persona");
Route::get("intereses", "PersonaController@intereses")->name("intereses.personas");
Route::get("listado-interesados", "PersonaController@listadoInteresados")->name("listado.intereses");
