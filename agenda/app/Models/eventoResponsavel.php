<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\evento;

class eventoResponsavel extends Model
{
    protected $fillable = [
        'userID',
        'eventoID'
    ];

    public function User(){
        return $this->hasOne(User::class, 'id', 'userID');    
    }

    public function Evento(){
        return $this->hasOne(evento::class, 'id', 'eventoID');    
    }
}
