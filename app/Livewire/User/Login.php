<?php

namespace App\Livewire\User;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

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
            'validado' => true 
        ];

        if (Auth::attempt($credentials)) {
            request()->session()->regenerate();

            $user = Auth::user();

            if ($user->role === 'admin') {
                return redirect()->intended(route('admin-dashboard'));
            }

            return redirect()->intended(route('dashboard'));
        }

        $usuarioExiste = User::where('email', $this->correo)->first();

        if ($usuarioExiste && !$usuarioExiste->validado) {
            session()->flash('error', 'Tu cuenta aún no está activa. Por favor, revisa tu correo electrónico para verificarla.');
            return;
        }

        session()->flash('error', 'Las credenciales ingresadas son incorrectas o no coinciden con nuestros registros.');
    }
    
    public function render()
    {
        return view('livewire.user.login');
    }
}