<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Intentos;
use App\Models\Tickets;
use Illuminate\Support\Facades\Auth;

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

        $this->dispatch('iniciar-juego');
    }

    #[On('guardar-score')]
    public function guardarScore($score)
    {
        if (!$this->jugando) {
            return;
        }

        Intentos::create([
            'user_id' => Auth::id(),
            'puntaje' => intval($score),
            'status' => 'aprobado',
        ]);

        $this->jugando = false;

        $this->actualizarRecord();
    }

    public function render()
    {
        return view('livewire.user.perfil');
    }
}