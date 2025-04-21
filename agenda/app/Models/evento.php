<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class evento extends Model
{
    protected $fillable = [
        'userId',
        'data',
        'titulo',
        'descricao'
    ];

    public function User(){
        return $this->hasOne(User::class, 'id', 'userId');    
    }
}
