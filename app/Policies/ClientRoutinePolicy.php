<?php

namespace App\Policies;

use App\Models\ClientRoutine;
use App\Models\User;

class ClientRoutinePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isTrainer();
    }

    public function view(User $user, ClientRoutine $clientRoutine): bool
    {
        return $user->isTrainer() && $clientRoutine->trainer_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->isTrainer();
    }

    public function update(User $user, ClientRoutine $clientRoutine): bool
    {
        return $this->view($user, $clientRoutine);
    }

    public function delete(User $user, ClientRoutine $clientRoutine): bool
    {
        return $this->view($user, $clientRoutine);
    }

    public function deleteAny(User $user): bool
    {
        return $user->isTrainer();
    }
}
