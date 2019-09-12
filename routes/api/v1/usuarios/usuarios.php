<?php
use Illuminate\Support\Facades\Route;

Route::get("listado", "UsuarioController@index")->name("listado.usuarios");
Route::post("editar/{id}", "UsuarioController@update")->name("editar.usuarios");
Route::get("roles", "UsuarioController@obtenerRoles")->name("roles.usuarios");
Route::post("asignar", "UsuarioController@asignarRol")->name("asignar.rol.usuario");
Route::post("remover", "UsuarioController@removerRol")->name("remover.rol.usuario");
Route::post("crear", "UsuarioController@store")->name("crear.usuario");
