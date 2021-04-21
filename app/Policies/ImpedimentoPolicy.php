<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Impedimento;
use Illuminate\Auth\Access\HandlesAuthorization;

class ImpedimentoPolicy
{
    use HandlesAuthorization;
    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function view(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can create
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
     * @param  \App\Models\Impedimento  $impedimento
     * @return mixed
     */
    public function edit(User $user, Impedimento $impedimento)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Impedimento  $impedimento
     * @return mixed
     */
    public function delete(User $user, Impedimento $impedimento)
    {
        return  $user->isAdmin();
    }
}
