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
    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }
    public function prazos()
    {
        return $this->hasMany(Prazo::class);

    }

    public function prazosOrdered()
    {
        // THIS WILL ALWAYS BE ORDERED BY EX-NAME
        return $this->prazos()
            ->join('exercicios', 'prazos.exercicio_id', '=', 'exercicios.id')
            ->select('prazos.*','exercicios.name as exercicio_name')
            ->orderBy('exercicio_name')
            ->orderBy('prazo')
            ;
    }
}
