<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercicio extends Model
{
    use HasFactory;
    protected $table = 'exercicios';
    protected $fillable = [
        'titulo',
        'enunciado',
        'preconds',
        'impedimentos'
    ];

    public function temNota()
    {
        return $this->notas->isNotEmpty();
    }

    public function temPrazo()
    {
        return $this->prazos->isNotEmpty();
    }

    public function testes()
    {
        return $this->hasMany(Teste::class);
    }

    // relationships
    public function users()
    {
        return $this->belongsToManyThrough(User::class,Nota::class);
    }
    public function turmas()
    {
        //return $this->belongsToManyThrough(Turma::class,Prazo::class);
        return $this->belongsToMany(Turma::class)->using(Prazo::Class);
    }
    public function prazos()
    {
        return $this->hasMany(Prazo::class);
    }
    public function notas()
    {
        return $this->hasMany(Nota::class);
    }
}
