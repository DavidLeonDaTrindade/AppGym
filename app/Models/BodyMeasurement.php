<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BodyMeasurement extends Model
{
    protected $fillable = [
        'client_id',
        'measured_at',
        'age',
        'training_years',
        'height_cm',
        'weight_kg',
        'body_mass_index',
        'muscle_mass_index',
        'body_fat_percentage',
        'muscle_mass_kg',
        'goal_weight_kg',
        'waist_cm',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'measured_at' => 'date',
            'age' => 'integer',
            'training_years' => 'integer',
            'height_cm' => 'decimal:2',
            'weight_kg' => 'decimal:2',
            'body_mass_index' => 'decimal:2',
            'muscle_mass_index' => 'decimal:2',
            'body_fat_percentage' => 'decimal:2',
            'muscle_mass_kg' => 'decimal:2',
            'goal_weight_kg' => 'decimal:2',
            'waist_cm' => 'decimal:2',
        ];
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }
}
