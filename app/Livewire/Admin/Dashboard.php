<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Tickets;
use App\Models\User;

class Dashboard extends Component
{
    public
    $totalUsuarios,
    $nuevosHoy,
    $ticketsPendientes,
    $totalPartidas,
    $recordGlobal,
    $ultimosUsuarios=[];



    public function index()
    {
        // 1. Estadísticas Generales
        $this->totalUsuarios = User::where('role', 'participante')->count();
        $this->nuevosHoy = User::where('role', 'participante')
            ->whereDate('created_at', Carbon::today())
            ->count();

        $this->ultimosUsuarios = User::where('role', 'participante')
        ->whereDate('created_at', Carbon::today())
        ->count();

        // 2. Control de Tickets
        $this->ticketsPendientes = Tickets::where('status', 'pendiente')->count();

        // 3. Actividad de Juego
        $this->totalPartidas = IntentoJuego::count();
        $this->recordGlobal = IntentoJuego::max('puntaje') ?? 0;

        // 4. Últimos Registros (para la tabla)
        $this->recordGlobal = User::where('role', 'participante')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard');
    }

}
