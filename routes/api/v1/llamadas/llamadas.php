<?php
use Illuminate\Support\Facades\Route;

Route::post("nueva", "LlamadaController@nueva")->name("nueva.llamada");
