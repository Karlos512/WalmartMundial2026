<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tickets extends Model
{
    use HasFactory;
    protected $table = 'tickets';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'id',
        'user_id',
        'image_path',
        'status',
        'intentos_disponibles',
        'motivo_rechazo'
    ];



    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}