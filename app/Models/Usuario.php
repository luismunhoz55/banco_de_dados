<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    public $timestamps = false;

    protected $primaryKey = 'id_usuario';

    protected $fillable = [
        'id_usuario',
        'nome',
        'email',
        'senha',
        'tipo'
    ];
}
