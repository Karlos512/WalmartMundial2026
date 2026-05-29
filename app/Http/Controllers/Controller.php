<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Intentos;
use App\Models\User;
use Illuminate\Support\Facades\DB;


class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function HomeView(){
        // consulta SQL limpia para el Top 10 único
        $ranking = intentos::select(
            'user_id',
            DB::raw('MAX(puntaje) as mejor_puntaje')
        )
        ->where('puntaje', '>', 0) 
        ->with('user:id,nickname')
        ->groupBy('user_id')
        ->orderByDesc('mejor_puntaje')
        ->limit(10)
        ->get();

        //retornamos la vista de bienvenida con la variable $ranking
        return view('welcome', compact('ranking'));
        //return view('welcome');
    }

    public function LoginView(){
        return view('UserViews.Login');
    }

    public function RegistroView(){
        return view('UserViews.Registro');
    }

    public function dashboardView(){
        return view('UserViews.Perfil');
    }

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('/'));
    }

    public function RecuperaPassword(){
        return view('UserViews.Recupera');
    }

    public function FormularioNuevoPassword($token, Request $request)
    {
        $usuario = User::where('email', $request->email)
                    ->where('password_reset_token', $token)
                    ->first();

        // Si el token no coincide lo botamos
        if (!$usuario) {
            return redirect()->route('recupera-password')->with('error', 'Esta liga de restablecimiento no es válida o ya caducó.');
        }

        return view('UserViews.NuevoPassword', [
            'token' => $token,
            'email' => $request->email
        ]);
    }

    public function VerificarCuenta($token, Request $request)
    {
        // Buscamos al usuario que coincida con el email y el token de activ
        $usuario = User::where('email', $request->email)
                    ->where('password_reset_token', $token)
                    ->first();

        if (!$usuario) {
            return redirect()->route('login')->with('error', 'El enlace de verificación no es válido o ya caducó.');
        }

        // Ejecutamos el UPDATE cambiamos a true y limpiamos el token
        $usuario->validado = true;
        $usuario->password_reset_token = null; 
        $usuario->save();

        // Lo mandamos al login con su mensaje listo para jugar
        return redirect()->route('login')->with('success', '¡Tu cuenta ha sido activada con éxito! Ya puedes iniciar sesión y competir.');
    }
}