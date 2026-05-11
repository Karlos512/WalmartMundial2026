<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Setting;


class Settings extends Component
{
    public $registro_abierto;
    public $juego_abierto;

    public function mount()
    {
        $this->registro_abierto = Setting::where('key', 'fase_registro')->value('value') === 'abierto';
        $this->juego_abierto = Setting::where('key', 'fase_juego')->value('value') === 'abierto';
    }

    public function toggleRegistro()
    {
        $this->registro_abierto = !$this->registro_abierto;
        Setting::updateOrCreate(
            ['key' => 'fase_registro'],
            ['value' => $this->registro_abierto ? 'abierto' : 'cerrado']
        );
        session()->flash('settings_msg', 'Estado de registro actualizado.');
    }

    public function toggleJuego()
    {
        $this->juego_abierto = !$this->juego_abierto;
        Setting::updateOrCreate(
            ['key' => 'fase_juego'],
            ['value' => $this->juego_abierto ? 'abierto' : 'cerrado']
        );
        session()->flash('settings_msg', 'Estado del minijuego actualizado.');
    }

    public function render()
    {
        return view('livewire.admin.settings');
    }
}
