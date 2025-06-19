<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Pessoa;

class Evento extends Model
{
    // Campos atribuíveis em massa
    protected $fillable = [
        'user_id',
        'titulo',
        'descricao',
        'data_ini',
        'data_fim',
        'status',
    ];

    /**
     * Relacionamento: Evento pertence a um Usuário
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relacionamento: Evento tem muitas Pessoas (profissionais e acolhidos)
     * A tabela intermediária é 'evento_pessoa' e as colunas de relacionamento são
     * 'evento_id' e 'pessoa_id'
     */
    public function pessoas()
    {
        return $this->belongsToMany(\App\Models\Pessoa::class, 'evento_pessoas', 'evento_id', 'pessoa_id');
    }

    protected $casts = [
        'data_ini' => 'datetime',
        'data_fim' => 'datetime',
    ];

    public function profissionais()
    {
        return $this->pessoas()->wherePivot('tipo_pessoa', 'Profissional');
    }

    public function acolhidos()
    {
        return $this->pessoas()->wherePivot('tipo_pessoa', 'Acolhido');
    }
}
