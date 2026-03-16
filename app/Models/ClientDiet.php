<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClientDiet extends Model
{
    protected $fillable = [
        'trainer_id',
        'client_id',
        'diet_id',
        'starts_at',
        'ends_at',
        'notes',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'starts_at' => 'date',
            'ends_at' => 'date',
            'is_active' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (self $assignment): void {
            if (! $assignment->is_active || ! $assignment->client_id) {
                return;
            }

            self::query()
                ->where('client_id', $assignment->client_id)
                ->whereKeyNot($assignment->getKey())
                ->where('is_active', true)
                ->update(['is_active' => false]);
        });
    }

    public function scopeCurrent(Builder $query): Builder
    {
        return $query
            ->where('is_active', true)
            ->where(function (Builder $builder): void {
                $builder->whereNull('starts_at')->orWhereDate('starts_at', '<=', now()->toDateString());
            })
            ->where(function (Builder $builder): void {
                $builder->whereNull('ends_at')->orWhereDate('ends_at', '>=', now()->toDateString());
            });
    }

    public function trainer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function diet(): BelongsTo
    {
        return $this->belongsTo(Diet::class);
    }
}
