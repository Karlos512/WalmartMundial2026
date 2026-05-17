<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class intentos extends Model
{
    use HasFactory;
    protected $table = 'intentos';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'id',
        'user_id',
        // 'ticket_id',
        'puntaje',
        'status',
    ];



    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}