<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('foods', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('trainer_id')->constrained('users')->cascadeOnDelete();
            $table->string('name');
            $table->string('brand')->nullable();
            $table->string('serving_reference')->default('100 g');
            $table->decimal('calories_kcal', 8, 2)->default(0);
            $table->decimal('protein_g', 8, 2)->default(0);
            $table->decimal('carbs_g', 8, 2)->default(0);
            $table->decimal('fat_g', 8, 2)->default(0);
            $table->decimal('fiber_g', 8, 2)->default(0);
            $table->decimal('sugar_g', 8, 2)->default(0);
            $table->decimal('sodium_mg', 8, 2)->default(0);
            $table->text('notes')->nullable();
            $table->string('source')->default('manual');
            $table->string('external_id')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['trainer_id', 'name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('foods');
    }
};
