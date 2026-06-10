<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ParticipantesExport implements FromQuery, WithHeadings, WithMapping
{
    public function query()
    {
        return User::query()
            ->where('role', 'participante')
            ->orderBy('name', 'asc');
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nombre Completo',
            'Correo Electrónico',
            'Ciudad',
            'Estado',
            'Estatus Cuenta',
            'Fecha de Registro'
        ];
    }

   
    public function map($user): array
    {
        return [
            $user->id,
            $user->name,
            $user->email,
            $user->ciudad ?? 'N/A',
            $user->estado ?? 'N/A',
            $user->activado ? 'INVALIDO' : ($user->validado ? 'ACTIVO' : 'PENDIENTE POR VERIFICAR'),
            $user->created_at ? $user->created_at->format('d/m/Y H:i') : 'S/F',
        ];
    }
}