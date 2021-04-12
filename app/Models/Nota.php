<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Prazo;
use App\Models\Turma;


class Nota extends Model
{
    use HasFactory;
    protected $table = 'notas';
    protected $guarded = [];
    protected $casts = [
        'testes' => 'array'
    ];

    // relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function exercicio()
    {
        return $this->belongsTo(Exercicio::class);
    }
}
