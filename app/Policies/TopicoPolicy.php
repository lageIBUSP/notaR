<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Topico;
use Illuminate\Auth\Access\HandlesAuthorization;

class TopicoPolicy
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
     * @param  \App\Models\Topico  $topico
     * @return mixed
     */
    public function view(User $user, Topico $topico)
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
     * @param  \App\Models\Topico  $topico
     * @return mixed
     */
    public function edit(User $user, Topico $topico)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Topico  $topico
     * @return mixed
     */
    public function delete(User $user, Topico $topico)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can reorder the models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function order(User $user)
    {
        return $user->isAdmin();
    }
}
