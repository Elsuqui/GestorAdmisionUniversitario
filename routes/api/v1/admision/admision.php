<?php
use Illuminate\Support\Facades\Route;

Route::apiResource("admisiones", "AdmisionController")
    ->except("delete");
Route::post("cambiar-estado-interes", "AdmisionController@cambiarEstadoInteres")
    ->name("cambiar.estado.interes");
