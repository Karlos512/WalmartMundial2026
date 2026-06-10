<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use App\Models\Tickets;
use App\Models\Intentos; 
use App\Models\Parametros;
use Carbon\Carbon;
use Livewire\WithPagination; 
use App\Exports\ParticipantesExport;
use Maatwebsite\Excel\Facades\Excel;

class Dashboard extends Component
{
    use WithPagination; 

    public $totalUsuarios = 0, $nuevosHoy = 0, $ticketsPendientes = 0, $totalPartidas = 0, $recordGlobal = 0;
    
    // Ajustes
    public $mostrarAjustes = false;
    public $registroActivo, $juegoActivo;

    //Control de Vistas 
    public $vistaActual = 'dashboard'; 
    public $usuarioSeleccionadoId;
    public $search = ''; 

     public function exportarExcel()
    {
        $fechaActual = Carbon::now()->format('d-m-Y');
        
        return Excel::download(new ParticipantesExport, "participantes_reto_{$fechaActual}.xlsx");
    }


    public function mount()
    {
        $this->registroActivo = (bool) Parametros::where('parametro', 'registro_activo')->value('activo');
        $this->juegoActivo = (bool) Parametros::where('parametro', 'juego_activo')->value('activo');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function irAVista($vista, $usuarioId = null)
    {
        $this->vistaActual = $vista;
        if ($usuarioId) {
            $this->usuarioSeleccionadoId = $usuarioId;
        }
    }

    // Ajustes de banderas
    public function toggleBloqueAjustes() { $this->mostrarAjustes = !$this->mostrarAjustes; }
    public function actualizarRegistro() { Parametros::where('parametro', 'registro_activo')->update(['activo' => $this->registroActivo]); }
    public function actualizarJuego() { Parametros::where('parametro', 'juego_activo')->update(['activo' => $this->juegoActivo]); }

    public function toggleSuspension($usuarioId)
    {
        $user = User::findOrFail($usuarioId);
        $user->suspendido = !$user->suspendido;
        $user->save();

        session()->flash('global_msg', 'Estado del usuario "' . $user->name . '" actualizado.');
    }

    public function declinarPartida($partidaId)
    {
        $partida = Intentos::findOrFail($partidaId);
        $partida->status = ($partida->status === 'declinado') ? 'aprobado' : 'declinado';
        $partida->save();

        session()->flash('global_msg', 'El estatus de la partida #' . $partidaId . ' fue modificado.');
    }

    public function render()
    {
        // Cargar datos para las tarjetas de arriba
        $this->totalUsuarios = User::where('role', 'participante')->count();
        $this->nuevosHoy = User::where('role', 'participante')->whereDate('created_at', Carbon::today())->count();
        $this->ticketsPendientes = Tickets::where('status', 'pendiente')->count();
        $this->totalPartidas = Intentos::count();
        $this->recordGlobal = Intentos::where('status', 'aprobado')->max('puntaje') ?? 0; // Solo récord de partidas limpias

        // Data segun la vista activa
        $ultimosUsuarios = [];
        $todosParticipantes = [];
        $partidasUsuario = [];
        $usuarioSeleccionado = null;

        if ($this->vistaActual === 'dashboard') {
            $ultimosUsuarios = User::where('role', 'participante')->orderBy('id', 'desc')->take(10)->get();
        } 
        elseif ($this->vistaActual === 'participantes') {
            $todosParticipantes = User::where('role', 'participante')
                ->where(function($query) {
                    $query->where('name', 'like', '%' . $this->search . '%')
                          ->orWhere('email', 'like', '%' . $this->search . '%');
                })
                ->orderBy('name', 'asc')
                ->paginate(10); // Paginación de 10 en 10
        } 
        elseif ($this->vistaActual === 'partidas') {
            $usuarioSeleccionado = User::findOrFail($this->usuarioSeleccionadoId);
            $partidasUsuario = Intentos::where('user_id', $this->usuarioSeleccionadoId)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('livewire.admin.dashboard', [
            'ultimosUsuarios' => $ultimosUsuarios,
            'todosParticipantes' => $todosParticipantes,
            'partidasUsuario' => $partidasUsuario,
            'usuarioSeleccionado' => $usuarioSeleccionado
        ]);
    }
}