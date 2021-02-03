<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Prazo extends Pivot
{

    protected $fillable = [
        'prazo'
    ];
    // relationships
    public function turma()
    {
        return $this->belongsTo(turma::class);
    }
    public function exercicio()
    {
        return $this->belongsTo(Exercicio::class);
    }
        

}
