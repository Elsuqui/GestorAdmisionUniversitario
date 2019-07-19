<?php
use Illuminate\Support\Facades\Route;

Route::apiResource("admisiones", "AdmisionController")
    ->except("delete");
