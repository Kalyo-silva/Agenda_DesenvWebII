<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pessoa extends Model
{
    protected $fillable = [
        'nome',
        'data_nascimento',
        'tipo_pessoa',
        'cpf',
        'telefone_contato',
        'foto_perfil',
    ];

    /**
     * Relacionamento: Pessoa tem muitos Eventos
     * A tabela intermediária é 'evento_pessoa' e as colunas de relacionamento são
     * 'evento_id' e 'pessoa_id'
     */
    public function eventos()
    {
        return $this->hasManyToMany(Evento::class, 'evento_pessoas')
            ->withPivot('tipo_pessoa');
    }
}
