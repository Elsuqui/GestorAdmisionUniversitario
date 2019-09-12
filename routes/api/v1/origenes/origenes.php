<?php
use Illuminate\Support\Facades\Route;

Route::get("/", "OrigenController@index")->name("origen.listado");
