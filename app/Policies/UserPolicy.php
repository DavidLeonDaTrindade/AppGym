<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isTrainer();
    }

    public function view(User $user, User $model): bool
    {
        return $user->isTrainer()
            && $model->isClient()
            && $model->trainer_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->isTrainer();
    }

    public function update(User $user, User $model): bool
    {
        return $this->view($user, $model);
    }

    public function delete(User $user, User $model): bool
    {
        return $this->view($user, $model);
    }

    public function deleteAny(User $user): bool
    {
        return $user->isTrainer();
    }
}
