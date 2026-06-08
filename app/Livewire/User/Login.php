<?php

namespace App\Livewire\User;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Parametros;

class Login extends Component
{
    public $correo, $password;

    protected $rules = [
        'correo' => 'required|email',
        'password' => 'required',
    ];

    protected $messages = [
        'correo.required' => 'El correo electrónico es obligatorio.',
        'correo.email' => 'Ingresa un formato de correo válido.',
        'password.required' => 'La contraseña es obligatoria.',
    ];

    public function login()
    {
        $this->validate();

        $credentials = [
            'email' => $this->correo,
            'password' => $this->password,
            'validado' => true,
            'suspendido' => false
        ];

        if (Auth::attempt($credentials)) {
            request()->session()->regenerate();

            $user = Auth::user();

            if ($user->role === 'admin') {
                return redirect()->intended(route('admin-dashboard'));
            }

            return redirect()->intended(route('dashboard'));
        }

        // --- MANEJO DE ERRORES CUANDO FALLA EL ATTEMPT PPPPP---
        $usuarioExiste = User::where('email', $this->correo)->first();

        if ($usuarioExiste) {
            if ($usuarioExiste->suspendido) {
                session()->flash('error', 'Tu cuenta ha sido suspendida por actividad sospechosa en el sistema.');
                return;
            }

            if (!$usuarioExiste->validado) {
                session()->flash('error', 'Tu cuenta aún no está activa. Por favor, revisa tu correo electrónico para verificarla.');
                return;
            }
        }

        session()->flash('error', 'Las credenciales ingresadas son incorrectas o no coinciden con nuestros registros.');
    }
    
    public function render()
    {
        return view('livewire.user.login');
    }
}