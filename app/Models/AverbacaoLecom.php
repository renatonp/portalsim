<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AverbacaoLecom extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'averbacao_lecom';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'cpf', 'cod_lecom', 'matricula', 'data_solicitacao'];
}
