<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
    use HasFactory;

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
