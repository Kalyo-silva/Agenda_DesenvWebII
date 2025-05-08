<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventoPessoa extends Model
{
    protected $table = 'evento_pessoas'; // Definindo explicitamente o nome da tabela

    protected $fillable = [
        'pessoa_id',
        'evento_id',
        'tipo_pessoa'
    ];

    // Definindo os relacionamentos com os modelos Pessoa e Evento
    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class, 'pessoa_id', 'id');
    }

    public function evento()
    {
        return $this->belongsTo(Evento::class, 'evento_id', 'id');
    }
}
