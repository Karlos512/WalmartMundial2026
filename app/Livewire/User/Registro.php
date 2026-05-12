<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class Registro extends Component
{
    public $nickname,$nombre, $paterno, $materno, $correo, $telefono, $fecha_nacimiento, $cp, $estado,$ciudad="",$colonia_seleccionada,$listcolonias= [], $password, $password_confirmation;
    public $aceptar_terminos = false;
    public $aceptar_privacidad = false;
    public $mostrarModalTerminos = false;
    public $mostrarModalPrivacidad = false;

    protected $rules = [
        'nombre' => 'required|min:2',
        'nickname' => 'required|string|min:3|max:20|unique:users,nickname',
        'paterno' => 'required|min:2',
        'materno' => 'required|min:2',
        'correo' => 'required|email|unique:users,email',
        'telefono' => 'required|digits:10',
        'fecha_nacimiento' => 'required',
        'password' => 'required|min:8|confirmed',
        'password_confirmation' => 'required',
        'cp' => 'required|digits:5',
        'estado' => 'required',
        'ciudad' => 'required',
        'colonia_seleccionada' => 'required',
        'aceptar_terminos' => 'accepted',
        'aceptar_privacidad' => 'accepted',
    ];

    protected $messages = [
        'password.confirmed' => 'Las contraseñas no coinciden.',
        'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
        'aceptar_terminos.accepted' => 'Debes aceptar los términos y condiciones para participar.',
        'aceptar_privacidad.accepted' => 'Debes aceptar el aviso de privacidad.',
    ];

    public function updatedNickname()
    {
        $this->validateOnly('nickname');
    }

    public function updatedCp($value)
    {
        if (strlen($value) === 5) {

            $this->loadaddresscp($value);
        }
    }

    public function loadaddresscp($cp){
        $response = Http::withToken('52|6vy7KEhWiu0Ed3oLHUvsHB8WKM2jzC3NP3N1wdUI5d762e6f')
        ->get("https://postalia.com.mx/api/codigos-postales/{$cp}");

        $data = $response->json();

        // dd($data['colonias']);
        $this->estado = $data['estado'] ?? '';
        $this->ciudad = $data['ciudad'] ?? $data['municipio'] ?? '';
        $this->listcolonias = $data['colonias'];

    }


    public function registrar()
    {
        $this->validate();

        $user = User::create([
            'nickname' => $this->nickname,
            'name' => $this->nombre,
            'email' => $this->correo,
            'password' => Hash::make($this->password),
            'apellido_paterno' => $this->paterno,
            'apellido_materno' => $this->materno,
            'telefono' => $this->telefono,
            'fecha_nacimiento'  => $this->fecha_nacimiento,
            'cp' => $this->cp,
            'estado' => $this->estado,
            'ciudad' => $this->ciudad,
            'colonia' => $this->colonia_seleccionada,
            'role' => 'participante', // Por defecto todos son participantes
            'aceptar_terminos'  => $this->aceptar_terminos,
            'aceptar_privacidad'=> $this->aceptar_privacidad,
        ]);

        // auth()->login($user);
        return redirect()->to('/login');
    }

    public function abrirTerminos() { $this->mostrarModalTerminos = true; }
    public function cerrarTerminos() { $this->mostrarModalTerminos = false; }

    public function abrirPrivacidad() { $this->mostrarModalPrivacidad = true; }
    public function cerrarPrivacidad() { $this->mostrarModalPrivacidad = false; }

    public function render()
    {
        return view('livewire.user.registro');
    }
}