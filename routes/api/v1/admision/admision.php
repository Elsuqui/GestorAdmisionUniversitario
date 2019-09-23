<?php
use Illuminate\Support\Facades\Route;

Route::apiResource("admisiones", "AdmisionController")
    ->except("delete");
Route::post("cambiar-estado-interes", "AdmisionController@cambiarEstadoInteres")
    ->name("cambiar.estado.interes");
Route::get("reporte-admision", "AdmisionController@reporteEstadosAdmision")
    ->name("reporte.admision");
Route::get("reporte-numero-ingresados", "AdmisionController@reporteNumeroIngresados")
    ->name("reporte.numero.ingresados");
