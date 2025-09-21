<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;


class usuarios extends Authenticatable implements JWTSubject
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'email',
        'password', 
        'roles',
        'esadmin',
        'habilitado'
    ];

    protected $hidden = [
        'password',
    ];


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

}