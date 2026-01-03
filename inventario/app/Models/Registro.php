<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registro extends Model
{
    /** @use HasFactory<\Database\Factories\RegistroFactory> */
    use HasFactory;

    protected $fillable = [
        'codigo', 'nombre', 'accion', 'tipo','usuario'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'usuario');
    }
}
