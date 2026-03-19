<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Diet extends Model
{
    protected $fillable = [
        'trainer_id',
        'title',
        'summary',
        'content',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function trainer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(ClientDiet::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(DietFood::class)->orderBy('sort_order')->orderBy('id');
    }
}
