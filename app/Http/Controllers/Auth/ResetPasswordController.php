<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function reset(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules(), [
            "password.required" => "La contraseña es requerida",
            "password.confirmed" => "Las contraseñas deben coincidir",
            "password.min" => "La contraseña debe tener por lo mínimo 8 caracteres"
        ]);
        //$validator = $request->validate($this->rules(), $this->validationErrorMessages());
        if (!$validator->passes()) {
            //TODO Handle your data
            return [
              "exito" => false,
              "mensaje" =>  $validator->errors()->first()
            ];
        }

        $response = $this->broker()->reset(
                $this->credentials($request), function ($user, $password) {
                $this->resetPassword($user, $password);
            }
        );

        return [
            "exito" => $response == Password::PASSWORD_RESET,
            "mensaje" => trans($response)
        ];
    }
}
