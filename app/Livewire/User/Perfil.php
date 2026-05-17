<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Tickets;
use App\Models\intentos;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Auth;

class Perfil extends Component
{
    use WithFileUploads;

    public $ticket,$nombre_archivo;
    public $mensaje = "";
    public $nickname, $mejorPuntaje;
    public $intentos=0;

    public function mount()
    {
        $this->obtenerRecord();
    }

    public function obtenerRecord()
    {
        $this->mejorPuntaje = intentos::where('user_id', auth()->id())
            ->max('puntaje') ?? 0;
    }

    public function guardar()
    {

        if (!$this->puedeSubirTicket) {
            session()->flash('error', 'Aún tienes intentos disponibles. ¡Gástalos antes de registrar otro ticket!');
            return;
        }

        $this->validate([
            'ticket' => 'image|max:2048', // Validación: imagen de max 2MB
        ]);

        $this->nombre_archivo = 'file_'.$this->username.'_'.$this->ticket->getClientOriginalName();
        $this->ticket->storeAs( '/',$this->nombre_archivo,'ticketsuploads');

        // Aquí guardarías el $path en tu base de datos
        // Ticket::create(['user_id' => Auth::id(), 'path' => $path]);
        $user = Tickets::create([
            'user_id' => Auth::user()->id,
            'image_path' =>  $this->nombre_archivo ,
            'status' => 'aprobado',
            'intentos_disponibles' => 3,
            'motivo_rechazo' => null
        ]);

        session()->flash('message', '¡Ticket enviado con éxito!');
        $this->reset('ticket');
    }

    public function getPuedeSubirTicketProperty()
    {
        $intentosRestantes = Tickets::where('user_id', Auth::user()->id)
            ->where('status', 'aprobado')
            ->where('intentos_disponibles', '>', 0)
            ->exists();

        return !$intentosRestantes;
    }

    public function getIntentosTotalesProperty()
    {
        return Tickets::where('user_id', Auth::user()->id)
            ->where('status', 'aprobado')
            ->sum('intentos_disponibles');
    }

    public function saveScore(){
        $score = rand (25, 525);

        intentos::create([
            'user_id' => Auth::user()->id,
            // 'ticket_id' =>  null ,
            'puntaje' => $score,
            'status' => 'aprobado',
        ]);
    }

    public function render()
    {

        $user = Auth::user();
        // $this->mejorPuntaje = "354";
        $this->nickname =  $user['nickname'];

        $this->intentos = $this->getIntentosTotalesProperty();
        // return view('livewire.user.perfil', [
        //     'username' => $user->name ?? 'Jugador',
        //     'mejorTiempo' => $mejorTiempo
        // ]);
        return view('livewire.user.perfil');
    }
}