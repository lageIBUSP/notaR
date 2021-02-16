<?php

namespace App\Policies;

use App\Models\Exercicio;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ExercicioPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Exercicio  $exercicio
     * @return mixed
     */
    public function view(User $user, Exercicio $exercicio)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Exercicio  $exercicio
     * @return mixed
     */
    public function edit(User $user, Exercicio $exercicio)
    {
        //
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Exercicio  $exercicio
     * @return mixed
     */
    public function delete(User $user, Exercicio $exercicio)
    {
        return $exercicio->temNota() || $exercicio->temPrazo() ?
                false // proibido deletar exercício com nota ou prazo
                : $user->isAdmin();
    }
}
