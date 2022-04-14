<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;

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

    // passado/futuro
    public function getPassadoAttribute() 
    {
        return $this->prazo < now(); 
    }
    public function getFuturoAttribute() 
    {
        return !$this->passado; 
    }

  public function scopeFuturos($query) {
        return $query->where('prazo', '>',  now());
    }
    public function scopePassados($query) {
        return $query->where('prazo', '<=', now());
    }
}
