<?php

namespace App\Policies;

use App\Models\Food;
use App\Models\User;

class FoodPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isTrainer();
    }

    public function view(User $user, Food $food): bool
    {
        return $user->isTrainer() && $food->trainer_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->isTrainer();
    }

    public function update(User $user, Food $food): bool
    {
        return $this->view($user, $food);
    }

    public function delete(User $user, Food $food): bool
    {
        return $this->view($user, $food);
    }

    public function deleteAny(User $user): bool
    {
        return $user->isTrainer();
    }
}
