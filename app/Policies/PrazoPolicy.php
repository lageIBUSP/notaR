<?php

namespace App\Policies;

use App\Models\Prazo;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PrazoPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Prazo  $prazo
     * @return mixed
     */
    public function view(User $user, Prazo $prazo)
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
     * @param  \App\Models\Prazo  $prazo
     * @return mixed
     */
    public function edit(User $user, Prazo $prazo)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Prazo  $prazo
     * @return mixed
     */
    public function delete(User $user, Prazo $prazo)
    {
        return $user->isAdmin();
    }
}
