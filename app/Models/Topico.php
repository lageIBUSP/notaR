<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topico extends Model
{
    use HasFactory;
    protected $table = 'topicos';
    protected $guarded = [];

    // relationships
    public function exercicios()
    {
        return $this->hasMany(Exercicio::class);
    }
}
