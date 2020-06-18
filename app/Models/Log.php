<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $fillable = [
        'cpf', 
        'data', 
        'servico',
        'ip',
        'browser',
        'descricao',
    ];

    public $timestamps = false;
}

