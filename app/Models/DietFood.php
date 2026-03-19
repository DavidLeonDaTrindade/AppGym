<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DietFood extends Model
{
    protected $table = 'diet_foods';

    protected $fillable = [
        'diet_id',
        'food_id',
        'meal_slot',
        'quantity_grams',
        'servings',
        'calories_kcal',
        'protein_g',
        'carbs_g',
        'fat_g',
        'fiber_g',
        'notes',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'quantity_grams' => 'decimal:2',
            'servings' => 'decimal:2',
            'calories_kcal' => 'decimal:2',
            'protein_g' => 'decimal:2',
            'carbs_g' => 'decimal:2',
            'fat_g' => 'decimal:2',
            'fiber_g' => 'decimal:2',
            'sort_order' => 'integer',
        ];
    }

    public function diet(): BelongsTo
    {
        return $this->belongsTo(Diet::class);
    }

    public function food(): BelongsTo
    {
        return $this->belongsTo(Food::class);
    }
}
