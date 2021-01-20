<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Turma;

class TurmaPolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        return $user->isAdmin();
    }

    public function update(User $user, Turma $turma)
    {
        return $user->isAdmin();
    }
}
