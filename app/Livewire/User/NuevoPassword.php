<?php
namespace App\Livewire\User;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class NuevoPassword extends Component
{
    public $token;
    public $email;

    public $password;
    public $password_confirmation;

    public function mount($token, $email)
    {
        $this->token = $token;
        $this->email = $email;
    }

    public function actualizarContrasena()
    {
        $this->validate([
            'password' => 'required|min:8|confirmed', // 'confirmed' busca automáticamente el campo 'password_confirmation'
        ], [
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
            'password.confirmed' => 'Las contraseñas ingresadas no coinciden.',
        ]);

        // usuario validando de forma estricta que coincida su email Y el token que guardamos
        $user = User::where('email', $this->email)
                    ->where('password_reset_token', $this->token)
                    ->first();

        if (!$user) {
            session()->flash('error', 'Este enlace de seguridad no es válido o ya fue utilizado anteriormente.');
            return;
        }

        $user->password = Hash::make($this->password);
        
        // token en null para no reutilziar esa liga
        $user->password_reset_token = null;
        $user->save();

        return redirect()->route('login')->with('success', '¡Tu contraseña ha sido actualizada con éxito! Ya puedes iniciar sesión.');
    }

    public function render()
    {
        return view('livewire.user.nuevo-password');
    }
}