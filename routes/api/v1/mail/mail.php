<?php

use Illuminate\Support\Facades\Route;

Route::post("enviar-mail-informativo", "MailController@enviarMailInformativo")->name("enviar_mail_informativo");
Route::get("personas-interesadas", "MailController@personasInteresadas")
    ->name("listado.personas-interesadas");
