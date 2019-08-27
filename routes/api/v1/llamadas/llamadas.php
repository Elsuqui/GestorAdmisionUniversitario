<?php
use Illuminate\Support\Facades\Route;

Route::post("nueva", "LlamadaController@nueva")->name("nueva.llamada");
Route::get("llamadas", "LlamadaController@reporteLlamadas")->name("nueva.llamada");
