<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teste extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $hidden = ['created_at','updated_at','id', 'exercicio_id'];

    // relationships
    public function exercicio()
    {
        return $this->belongsTo(Exercicio::class);
    }
}
