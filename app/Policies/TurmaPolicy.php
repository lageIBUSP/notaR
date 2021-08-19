<?php

namespace App\Policies;

use App\Models\Turma;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TurmaPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the list or index.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function list(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Turma  $turma
     * @return mixed
     */
    public function view(User $user, Turma $turma)
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
     * @param  \App\Models\Turma  $turma
     * @return mixed
     */
    public function edit(User $user, Turma $turma)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Turma  $turma
     * @return mixed
     */
    public function delete(User $user, Turma $turma)
    {
        return $turma->temAluno() || $turma->temPrazo()?
                false // proibido deletar turma com aluno
                : $user->isAdmin();
    }
}
