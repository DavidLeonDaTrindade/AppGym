<?php

namespace App\Policies;

use App\Models\Routine;
use App\Models\User;

class RoutinePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isTrainer();
    }

    public function view(User $user, Routine $routine): bool
    {
        return $user->isTrainer() && $routine->trainer_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->isTrainer();
    }

    public function update(User $user, Routine $routine): bool
    {
        return $this->view($user, $routine);
    }

    public function delete(User $user, Routine $routine): bool
    {
        return $this->view($user, $routine);
    }

    public function deleteAny(User $user): bool
    {
        return $user->isTrainer();
    }
}
