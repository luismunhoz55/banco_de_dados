<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    /** @use HasFactory<\Database\Factories\ClienteFactory> */
    use HasFactory;

    protected $primaryKey = 'id_cliente';

    public $timestamps = false;

    protected $fillable = [
        'nome_empresa',
        'cnpj',
        'telefone'
    ];
}
