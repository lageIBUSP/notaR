<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;
use Stephenjude\DefaultModelSorting\Traits\DefaultOrderBy;

class Prazo extends Pivot
{
    use HasFactory;
    protected $table = 'prazos';

    /**
     * Set a default ordering for this model
     */
    use DefaultOrderBy;
    protected static $orderByColumn = 'prazo';

    public function prazoParsed()
    {
        return Carbon::parse($this->prazo);
    }

    // shift prazo by a fixed ammount
    public function shiftBy(int $days)
    {
        $this->prazo = $this->prazoParsed()->addDays($days);
    }

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
