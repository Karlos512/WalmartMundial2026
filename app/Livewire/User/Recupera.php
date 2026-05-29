<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class Recupera extends Component
{
    public $email;

    public function enviarCorreo()
    {
        $this->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Por favor, ingresa un formato de correo válido.',
            'email.exists' => 'Este correo electrónico no está registrado en el sistema.',
        ]);

        $user = User::where('email', $this->email)->first();

        $token = Str::random(64);
        $user->password_reset_token = $token;
        $user->save();

        $ligaUnica = route('password.reset', ['token' => $token, 'email' => $this->email]);

        // correo electrónico
        Mail::send([], [], function ($message) use ($ligaUnica) {
            $message->to($this->email)
                    ->subject('Restablecer Contraseña - Reto Walmart Mundial 2026 - CandyGame')
                    ->html("
                        <div style='font-family: sans-serif; max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; border: 1px solid #eee;'>
                            <h2 style='color: #e30613; text-transform: uppercase;'>Restablecer Contraseña</h2>
                            <p>Recibimos una solicitud para cambiar la contraseña de tu cuenta en CandyGame.</p>
                            <p>Para continuar con el restablecimiento, haz clic en el siguiente botón. Esta liga es de uso único.</p>
                            <div style='text-align: center; margin: 30px 0;'>
                                <a href='{$ligaUnica}' style='background-color: #e30613; color: white; padding: 12px 30px; text-decoration: none; font-weight: bold; border-radius: 5px; display: inline-block;'>
                                    RESTABLECER MI CONTRASEÑA
                                </a>
                            </div>
                            <p style='font-size: 11px; color: #aaa;'>Si tú no solicitaste este cambio, puedes ignorar este correo de forma segura.</p>
                        </div>
                    ");
        });

        $this->reset('email');
        session()->flash('success', '¡Te hemos enviado un correo con la liga de restablecimiento!');
        return redirect()->route('login')->with('success', '¡Excelente! Te hemos enviado un correo con la liga para restablecer tu contraseña. Revisa tu bandeja de entrada.');
    }

    public function render()
    {
        return view('livewire.user.recupera');
    }
}