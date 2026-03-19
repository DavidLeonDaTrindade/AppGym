<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('body_measurements', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('client_id')->constrained('users')->cascadeOnDelete();
            $table->date('measured_at');
            $table->unsignedInteger('age')->default(0);
            $table->unsignedInteger('training_years')->default(0);
            $table->decimal('height_cm', 6, 2)->default(0);
            $table->decimal('weight_kg', 6, 2)->default(0);
            $table->decimal('body_mass_index', 6, 2)->default(0);
            $table->decimal('muscle_mass_index', 6, 2)->default(0);
            $table->decimal('body_fat_percentage', 6, 2)->default(0);
            $table->decimal('muscle_mass_kg', 6, 2)->default(0);
            $table->decimal('goal_weight_kg', 6, 2)->default(0);
            $table->decimal('waist_cm', 6, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['client_id', 'measured_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('body_measurements');
    }
};
