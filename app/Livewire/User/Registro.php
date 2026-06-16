<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

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

        $tokenVerificacion = Str::random(64);

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
            'role' => 'participante',
            'aceptar_terminos'  => $this->aceptar_terminos,
            'aceptar_privacidad'=> $this->aceptar_privacidad,

            // Tus dos campos clave de control
            'validado' => false,
            'password_reset_token' => $tokenVerificacion,
            'suspendido' => false,

        ]);

        $ligaVerificacion = route('cuenta.verificar', ['token' => $tokenVerificacion, 'email' => $user->email]);

        Mail::send([], [], function ($message) use ($user, $ligaVerificacion) {
            $message->to($user->email)
                    ->subject('¡Activa tu cuenta de competidor!')
                    ->html("
                        <div style='font-family: sans-serif; max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; border: 1px solid #eee;'>
                            <h2 style='color: #e30613; text-transform: uppercase; text-align: center;'>¡Bienvenido a CandyGame!</h2>
                            <p>Hola <strong>{$user->name}</strong>,</p>
                            <p>Tu registro se ha realizado con éxito en nuestra plataforma de competencia.</p>
                            <p>Para poder ingresar, confirmar tu identidad y comenzar a acumular puntos, es necesario que actives tu cuenta haciendo clic en el siguiente botón:</p>

                            <div style='text-align: center; margin: 30px 0;'>
                                <a href='{$ligaVerificacion}' style='background-color: #e30613; color: white; padding: 12px 30px; text-decoration: none; font-weight: bold; border-radius: 5px; display: inline-block; text-transform: uppercase;'>
                                    Confirmar mi correo
                                </a>
                            </div>

                            <p style='font-size: 11px; color: #aaa; text-align: center;'>Si tú no realizaste este registro, puedes ignorar este correo de forma segura.</p>
                        </div>
                    ");
        });

        return redirect()->to('/login')->with('success', '¡Registro exitoso! Te hemos enviado un correo de verificación. Por favor, revisa tu bandeja de entrada para activar tu cuenta.');
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
