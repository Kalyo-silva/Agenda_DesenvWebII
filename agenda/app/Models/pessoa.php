<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pessoa extends Model
{
    protected $fillable = ['nome', 'data_nascimento', 'cpf', 'telefone_contato'];
}
