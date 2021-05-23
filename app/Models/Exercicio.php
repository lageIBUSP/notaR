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
        'precondicoes',
        'draft'
    ];

    /**
    * Scope a query to only include active users.
    *
    * @param  \Illuminate\Database\Eloquent\Builder  $query
    * @return \Illuminate\Database\Eloquent\Builder
    */
    public function scopePublished($query)
    {
        return $query->where('draft', false);
    }

    public function temNota()
    {
        return $this->notas->isNotEmpty();
    }

    public function temPrazo()
    {
        return $this->prazos->isNotEmpty();
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
