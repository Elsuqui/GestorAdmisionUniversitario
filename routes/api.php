<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::prefix('v1/archivos')
    //->middleware(['api', 'auth'])
    ->namespace('Api\v1\Archivos')
    ->as('api.v1.archivos.')
    ->group(base_path('routes/api/v1/archivos/archivos.php'));

Route::prefix("v1/mail")
    ->namespace('Api\v1\Mail')
    ->as('api.v1.mail.')
    ->group(base_path('routes/api/v1/mail/mail.php'));

Route::prefix("v1/admision")
    ->namespace('Api\v1\Admision')
    ->as('api.v1.admision.')
    ->group(base_path('routes/api/v1/admision/admision.php'));

Route::prefix("v1/personas")
    ->namespace('Api\v1\Persona')
    ->as('api.v1.persona')
    ->group(base_path('routes/api/v1/personas/personas.php'));

Route::prefix("v1/llamadas")
    ->namespace('Api\v1\Llamada')
    ->as('api.v1.llamada')
    ->group(base_path('routes/api/v1/llamadas/llamadas.php'));

Route::prefix("v1/usuarios")
    ->namespace('Api\v1\Usuario')
    ->as('api.v1.usuarios')
    ->group(base_path('routes/api/v1/usuarios/usuarios.php'));

Route::prefix("v1/origenes")
    ->namespace('Api\v1\Origen')
    ->as('api.v1.origenes')
    ->group(base_path('routes/api/v1/origenes/origenes.php'));
