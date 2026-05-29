<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'users';

    protected $fillable = [
        'name',
        'nickname',
        'apellido_paterno',
        'apellido_materno',
        'email',
        'telefono',
        'cp',
        'estado',
        'ciudad',
        'colonia',
        'fecha_nacimiento',
        'password',
        'role',
        'aceptar_terminos',
        'aceptar_privacidad',
        'password_reset_token'
    ];
    protected $primaryKey = 'id';
    public $timestamps = true;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];
}