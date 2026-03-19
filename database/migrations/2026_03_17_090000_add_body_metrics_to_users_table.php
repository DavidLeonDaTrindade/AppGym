<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->unsignedInteger('age')->default(0)->after('notes');
            $table->unsignedInteger('training_years')->default(0)->after('age');
            $table->decimal('height_cm', 6, 2)->default(0)->after('training_years');
            $table->decimal('weight_kg', 6, 2)->default(0)->after('height_cm');
            $table->decimal('body_mass_index', 6, 2)->default(0)->after('weight_kg');
            $table->decimal('muscle_mass_index', 6, 2)->default(0)->after('body_mass_index');
            $table->decimal('body_fat_percentage', 6, 2)->default(0)->after('muscle_mass_index');
            $table->decimal('muscle_mass_kg', 6, 2)->default(0)->after('body_fat_percentage');
            $table->decimal('goal_weight_kg', 6, 2)->default(0)->after('muscle_mass_kg');
            $table->decimal('waist_cm', 6, 2)->default(0)->after('goal_weight_kg');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->dropColumn([
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
            ]);
        });
    }
};
