<?php

namespace App\Policies;

use App\Models\ClientDiet;
use App\Models\User;

class ClientDietPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isTrainer();
    }

    public function view(User $user, ClientDiet $clientDiet): bool
    {
        return $user->isTrainer() && $clientDiet->trainer_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->isTrainer();
    }

    public function update(User $user, ClientDiet $clientDiet): bool
    {
        return $this->view($user, $clientDiet);
    }

    public function delete(User $user, ClientDiet $clientDiet): bool
    {
        return $this->view($user, $clientDiet);
    }

    public function deleteAny(User $user): bool
    {
        return $user->isTrainer();
    }
}
