<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\pessoa;
use App\Models\evento;

class eventoPessoa extends Model
{
    protected $fillable = [
        'pessoaID',
        'eventoID'
    ];

    public function Pessoa(){
        return $this->hasOne(pessoa::class, 'id', 'pessoaID');    
    }

    public function Evento(){
        return $this->hasOne(evento::class, 'id', 'eventoID');    
    }
}
