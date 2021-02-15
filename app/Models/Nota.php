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

    /**
     * Turmas para as quais essa nota é válida no prazo
     *
     * @return Turma[]
     */
    public function turmas () {
        return $this->prazos->pluck('turma');
    }

    /**
     * Prazos para os quais essa nota é válida
     *
     * @return Prazo[]
     */
    public function prazos () {
        $prazos = $this->user->turmas->prazos->where('exercicio',$this->exercicio);
        return $prazos->where('prazo','>',$this->createdAt);
    }

    // scopes
    /**
     * Válido para esse prazo
     *
     * 
     * 
     */
    public function scopeNoPrazo ($query, Prazo $prazo) {
        // todo verificar se o prazo é válido pra essa nota
        return $query->where($prazo->prazo,'>',$this->createdAt);
    }

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
