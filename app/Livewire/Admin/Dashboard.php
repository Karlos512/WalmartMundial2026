<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
//use App\Models\Tickets;
use App\Models\Intentos; 
use Carbon\Carbon;

class Dashboard extends Component
{
    public $totalUsuarios = 0;
    public $nuevosHoy = 0;
    public $puntajePendiente = 0;
    public $totalPartidas = 0;
    public $recordGlobal = 0;

    public function render()
    {
        $this->totalUsuarios = User::where('role', 'participante')->count();
        
        $this->nuevosHoy = User::where('role', 'participante')
            ->whereDate('created_at', Carbon::today())
            ->count();

            ///////////pendiengte de validar par que es --------- cambiamos por partidas por validar
        $this->puntajePendiente = Intentos::where('status', 'pendiente')->count();

        $this->totalPartidas = Intentos::count(); 
        
        $this->recordGlobal = Intentos::max('puntaje') ?? 0; 

        $ultimosUsuarios = User::where('role', 'participante')
            ->orderBy('id', 'desc')
            ->take(10)
            ->get();

        return view('livewire.admin.dashboard', [
            'ultimosUsuarios' => $ultimosUsuarios
        ]);
    }
}