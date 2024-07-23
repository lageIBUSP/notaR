<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stephenjude\DefaultModelSorting\Traits\DefaultOrderBy;

class Topico extends Model
{
    use HasFactory;
    protected $table = 'topicos';
    protected $guarded = [];

    /**
     * Set a default ordering for this model
     */
    use DefaultOrderBy;
    protected static $orderByColumn = 'order';

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
