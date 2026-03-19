<?php

namespace App\Providers;

use App\Models\ClientDiet;
use App\Models\ClientRoutine;
use App\Models\Diet;
use App\Models\Food;
use App\Models\Routine;
use App\Models\User;
use App\Policies\ClientDietPolicy;
use App\Policies\ClientRoutinePolicy;
use App\Policies\DietPolicy;
use App\Policies\FoodPolicy;
use App\Policies\RoutinePolicy;
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::policy(User::class, UserPolicy::class);
        Gate::policy(Routine::class, RoutinePolicy::class);
        Gate::policy(Diet::class, DietPolicy::class);
        Gate::policy(Food::class, FoodPolicy::class);
        Gate::policy(ClientRoutine::class, ClientRoutinePolicy::class);
        Gate::policy(ClientDiet::class, ClientDietPolicy::class);

        Gate::define('access-client-area', fn (User $user): bool => $user->isClient() && $user->is_active);
        Gate::define('manage-fitness', fn (User $user): bool => $user->isTrainer() && $user->is_active);
    }
}
