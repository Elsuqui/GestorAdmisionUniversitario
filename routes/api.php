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
