<?php

namespace App\Policies;

use App\Models\Diet;
use App\Models\User;

class DietPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isTrainer();
    }

    public function view(User $user, Diet $diet): bool
    {
        return $user->isTrainer() && $diet->trainer_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->isTrainer();
    }

    public function update(User $user, Diet $diet): bool
    {
        return $this->view($user, $diet);
    }

    public function delete(User $user, Diet $diet): bool
    {
        return $this->view($user, $diet);
    }

    public function deleteAny(User $user): bool
    {
        return $user->isTrainer();
    }
}
