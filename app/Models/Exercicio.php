<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercicio extends Model
{
    use HasFactory;
    protected $table = 'exercicios';
    protected $fillable = [
        'name',
        'description',
        'preconds'
    ];

    public function temNota()
    {
        return $this->notas->isNotEmpty();
    }
    public function prazoEm(Turma $turma)
    {
        $prazo = $this->prazos()->where('turma_id',$turma->id)->first();
        return $prazo ? $prazo->prazo : "";
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
    public function prazos()
    {
        return $this->hasMany(Prazo::class);
    }
    public function notas()
    {
        return $this->hasMany(Nota::class);
    }
}
