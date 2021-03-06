<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turma extends Model
{
    use HasFactory;
    protected $table = 'turmas';
    protected $guarded = [];

    public function temAluno() {
        return $this->users->isNotEmpty();
    }

    public function temPrazo() {
        return $this->prazos->isNotEmpty();
    }

    // relationships
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    public function prazos()
    {
        return $this->hasMany(Prazo::class);
    }
}
