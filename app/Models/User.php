<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
        return true;
    }

    
    // relatonships
    public function turmas()
    {
        return $this->belongsToMany(Turmas::class);
    }
    public function notas()
    {
        return $this->hasMany(Nota::class);
    }
    public function exerciciosFeitos()
    {
        return $this->hasManyThrough(Exercicio::class,Nota::Class);
    }
    public function prazos()
    {
        return $this->hasManyThrough(Prazo::class,Turma::class)
    }
}
