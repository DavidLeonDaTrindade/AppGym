<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('diet_foods', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('diet_id')->constrained()->cascadeOnDelete();
            $table->foreignId('food_id')->constrained('foods')->restrictOnDelete();
            $table->string('meal_slot')->nullable();
            $table->decimal('quantity_grams', 8, 2)->default(100);
            $table->decimal('servings', 8, 2)->default(1);
            $table->decimal('calories_kcal', 8, 2)->default(0);
            $table->decimal('protein_g', 8, 2)->default(0);
            $table->decimal('carbs_g', 8, 2)->default(0);
            $table->decimal('fat_g', 8, 2)->default(0);
            $table->decimal('fiber_g', 8, 2)->default(0);
            $table->text('notes')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['diet_id', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('diet_foods');
    }
};
