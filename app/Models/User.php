<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public const ROLE_TRAINER = 'trainer';
    public const ROLE_CLIENT = 'client';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
        'trainer_id',
        'notes',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'is_active' => 'boolean',
            'password' => 'hashed',
        ];
    }

    public function trainer(): BelongsTo
    {
        return $this->belongsTo(self::class, 'trainer_id');
    }

    public function clients(): HasMany
    {
        return $this->hasMany(self::class, 'trainer_id');
    }

    public function routines(): HasMany
    {
        return $this->hasMany(Routine::class, 'trainer_id');
    }

    public function diets(): HasMany
    {
        return $this->hasMany(Diet::class, 'trainer_id');
    }

    public function clientRoutineAssignments(): HasMany
    {
        return $this->hasMany(ClientRoutine::class, 'client_id');
    }

    public function clientDietAssignments(): HasMany
    {
        return $this->hasMany(ClientDiet::class, 'client_id');
    }

    public function managedRoutineAssignments(): HasMany
    {
        return $this->hasMany(ClientRoutine::class, 'trainer_id');
    }

    public function managedDietAssignments(): HasMany
    {
        return $this->hasMany(ClientDiet::class, 'trainer_id');
    }

    public function isTrainer(): bool
    {
        return $this->role === self::ROLE_TRAINER;
    }

    public function isClient(): bool
    {
        return $this->role === self::ROLE_CLIENT;
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $panel->getId() === 'admin' && $this->isTrainer() && $this->is_active;
    }
}
