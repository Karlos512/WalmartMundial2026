<?php

namespace App\Livewire\User;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class Login extends Component
{
    // public $correo, $password, $recordar = false;
    public $correo,$password;

    protected $rules = [
        'correo' => 'required|email',
        'password' => 'required',
    ];

    public function login(Request $request){
        $credentials = [
            'email' => $this->correo,
            'password' => $this->password
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            if ($user->role === 'admin') {
                return redirect()->intended(route('/'));
            }

            // dd($user);
            return redirect()->intended(route('dashboard'));
        }
        // dd('no entro');
        return redirect(route('/'))->with('error', 'Credenciales incorrectas');
    }

    public function render()
    {
        return view('livewire.user.login');
    }
}