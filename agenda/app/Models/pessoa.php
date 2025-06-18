<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Evento;

class Pessoa extends Model
{
    protected $fillable = [
        'nome',
        'data_nascimento',
        'tipo_pessoa',
        'cpf',
        'telefone_contato',
        'foto_perfil',
        'usuario_id', // <- adicionado
    ];

    /**
     * Relacionamento: Pessoa pertence a um Usuário
     */
    public function usuario()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relacionamento: Pessoa participa de muitos Eventos
     */
    public function eventos()
    {
        return $this->belongsToMany(Evento::class, 'evento_pessoas')
                    ->withPivot('tipo_pessoa');
    }
}
