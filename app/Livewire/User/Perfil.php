<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Intentos;
use App\Models\Tickets;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;


class Perfil extends Component
{
    public $nickname;
    public $mejorPuntaje = 0;
    public $jugando = false;

    public function mount()
    {
        $this->nickname = auth()->user()->nickname;

        $this->actualizarRecord();
    }

    public function actualizarRecord()
    {
        $this->mejorPuntaje =
            Intentos::where('user_id', auth()->id())
            ->max('puntaje') ?? 0;
    }


    public function iniciarIntento()
    {
        $this->jugando = true;

        // generamos un token y registramos la hora de inicio
        $tokenJuego = Str::random(32); 
        Session::put('juego_token', $tokenJuego);
        Session::put('juego_inicio_at', Carbon::now());

        // pasamos el token al frontend de forma segura a través del evento
        $this->dispatch('iniciar-juego', ['token' => $tokenJuego]);
    }

    #[On('guardar-score')]
    public function guardarScore($score, $token = null)
    {
        if (is_array($score)) {
            $token = $score['token'] ?? null;
            $score = $score['score'] ?? 0;
        }

        if (!$this->jugando) {
            return;
        }

        $tokenSesion = Session::get('juego_token');
        $inicio = Session::get('juego_inicio_at');

        if (!$tokenSesion || $tokenSesion !== $token) {
            $this->limpiarSesionJuego();
            return;
        }

        Session::forget('juego_token');

        $score = intval($score);
        $tiempoTranscurrido = Carbon::now()->diffInSeconds($inicio);

        if ($tiempoTranscurrido < 53) {
            $this->limpiarSesionJuego();
            return; 
        }

        //tiempodinamico calculado
        $tiempoMaximoPermitido = 95 + ($score * 0.25);

        if ($tiempoTranscurrido > $tiempoMaximoPermitido) {
            $this->limpiarSesionJuego();
            return; 
        }

        $maximoPuntajePosible = 30000; 
        if ($score > $maximoPuntajePosible) {
            $this->limpiarSesionJuego();
            return;
        }

        //si todos los candados se aprueab
        Intentos::create([
            'user_id' => Auth::id(),
            'puntaje' => $score,
            'status' => 'aprobado',
        ]);

        // Actualizamos el piuntale visual del usuario
        $this->actualizarRecord();

        // Congelamos la pantalla los 30 segundos para share en redes
        sleep(30); 
        
        $this->jugando = false;
        Session::forget('juego_inicio_at');
    }

    private function limpiarSesionJuego()
    {
        $this->jugando = false;
        Session::forget('juego_token');
        Session::forget('juego_inicio_at');
        Session()->flash('error', ' pelas trmaposo');
    }

    public function render()
    {
        return view('livewire.user.perfil');
    }
}