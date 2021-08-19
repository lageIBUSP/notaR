<?php

namespace App\Policies;

use App\Models\Arquivo;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArquivoPolicy
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
     * @param  \App\Models\Arquivo  $arquivo
     * @return mixed
     */
    public function edit(User $user, Arquivo $arquivo)
    {
        //
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Arquivo  $arquivo
     * @return mixed
     */
    public function delete(User $user, Arquivo $arquivo)
    {
        return  $user->isAdmin();
    }
}
