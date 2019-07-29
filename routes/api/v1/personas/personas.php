<?php
use Illuminate\Support\Facades\Route;

Route::get("busqueda", "PersonaController@busqueda")->name("buscar.persona");
