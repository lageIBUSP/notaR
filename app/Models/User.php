<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /** 
    * Sets a hashed password
    */
    public function setPasswordAttribute($value) {
        $this->attributes['password'] = Hash::make($value);
    }

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'is_admin' => false,
        'name' => "",
        'password' => "",
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isAdmin() {
        return $this->is_admin;
    }

    /**
     * Nota final (atual) dentro do prazo (get from DB)
     *
     * @var App\Model\Prazo $prazo
     * @return float
     */
    public function getNotaFinal(Prazo $prazo) {
        return $this->notas()->
                where('exercicio_id',$prazo->exercicio_id)-> //exercicio correto
                where('created_at','<',$prazo->prazo)-> //dentro do prazo
                get()->max('nota'); //maior nota
    }

    /**
     * Nota final (atual) dentro do prazo
     *
     * @var App\Model\Prazo $prazo
     * @return float
     */
    public function notaFinal(Prazo $prazo) {
        return $this->notasValidas($prazo)->max('nota'); //maior nota
    }

    /**
     * Notas dentro do prazo
     *
     * @var App\Model\Prazo $prazo
     */
    public function notasValidas(Prazo $prazo) {
        return $this->notas
                ->where('exercicio_id',$prazo->exercicio_id) //exercicio correto
                ->where('created_at','<',$prazo->prazo) //dentro do prazo
                ; 
    }

    public function temNota() {
        return $this->notas->isNotEmpty();
    }

    // relatonships
    public function turmas()
    {
        return $this->belongsToMany(Turma::class);
    }
    public function notas()
    {
        return $this->hasMany(Nota::class);
    }

    // acessors
    public function getPrazosAttribute()
    {
        return $this->turmas()->with(['prazos','prazos.exercicio','prazos.turma'])
        ->get()->pluck('prazos')->collapse()
        ->sortBy('exercicio.name')->sortBy('prazo');
    }
}
