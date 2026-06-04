<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use App\Models\Parametros;
use App\Models\Intentos; 
use Carbon\Carbon;

class Dashboard extends Component
{
    public $totalUsuarios = 0;
    public $nuevosHoy = 0;

    //boton de ajusres
    public $mostrarAjustes = false;

    //banderas
    public $registroActivo;
    public $juegoActivo;

    public $puntajePendiente = 0;
    public $totalPartidas = 0;
    public $recordGlobal = 0;

    public function mount(){
        $this->registroActivo = (bool) Parametros::where('parametro', 'registro_activo')->value('activo');
        $this->juegoActivo = (bool) Parametros::where('parametro', 'juego_activo')->value('activo');
    }

    public function toggleBloqueAjustes()
    {
        $this->mostrarAjustes = !$this->mostrarAjustes;
    }

    public function actualizarRegistro()
    {
        Parametros::where('parametro', 'registro_activo')->update(['activo' => $this->registroActivo]);
        session()->flash('status_ajustes', 'Configuración de registros actualizada.');
    }

    public function actualizarJuego()
    {
        Parametros::where('parametro', 'juego_activo')->update(['activo' => $this->juegoActivo]);
        session()->flash('status_ajustes', 'Configuración del juego actualizada.');
    }

    public function render()
    {
        $this->totalUsuarios = User::where('role', 'participante')->count();
        
        $this->nuevosHoy = User::where('role', 'participante')
            ->whereDate('created_at', Carbon::today())
            ->count();

        /////////pendiengte de validar par que es --------- cambiamos por partidas por validar
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