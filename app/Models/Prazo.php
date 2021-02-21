<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prazo extends Pivot
{
    use HasFactory;
    protected $table = 'prazos';

    protected $guarded = [];
    // relationships
    public function turma()
    {
        return $this->belongsTo(Turma::class);
    }
    public function exercicio()
    {
        return $this->belongsTo(Exercicio::class);
    }
}
