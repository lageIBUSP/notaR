<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topico extends Model
{
    use HasFactory;
    protected $table = 'topicos';

    // relationships
    public function exercicios()
    {
        return $this->hasMany(Exercicio::class);
    }
    // scope published
    public function exerciciosPublished()
    {
        return $this->hasMany(Exercicio::class)->published();
    }
}
