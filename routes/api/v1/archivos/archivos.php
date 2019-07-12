<?php

use Illuminate\Support\Facades\Route;

Route::post("importar-excel-base", "ArchivosController@subirExcelBase")->name("subir.excel.base");
