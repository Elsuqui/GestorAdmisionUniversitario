<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }


    /**
     * Sobre escribo el método para seleccionar el campo de autenticación
     * en este caso nombre del usuario
     */
    public function username()
    {
        return "username";
    }

    /**
     * Método para iniciar sesión
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function ingresar(Request $request)
    {
        $error = "";
        $remember = $request["remember"];
        try{
            $success = Auth::attempt($request->only(["username", "password"]), $remember);
        }catch(\Exception $exception){
            $error = $exception->getMessage();
        }

        return response()->json([
            "success" => $success,
            "redirect" => $success ? $this->redirectTo : "",
            "error" => $error
            ]);
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->flush();
        $request->session()->regenerate();

        return redirect("/login");
    }
}
