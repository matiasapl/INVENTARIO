<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroProductos extends Model
{
    /** @use HasFactory<\Database\Factories\RegistroProductosFactory> */
    use HasFactory;
    protected $fillable = [
        'codigo', 'descripcion', 'ubicacion', 'categoria', 'precio', 'm3', 'usuario', 'habilitado', 'eliminado'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'usuario');
    }
}
