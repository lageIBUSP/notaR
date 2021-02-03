<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turma extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description'
    ];

    // relationships
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    public function prazos()
    {
        return $this->hasMany(Prazo::class);
    }
    public function exercicios()
    {
        return $this->belongsToMany(Exercicio::class)->using(Prazo::Class);
        //return $this->hasManyThrough(Exercicio::class,Prazo::Class);
    }
}
