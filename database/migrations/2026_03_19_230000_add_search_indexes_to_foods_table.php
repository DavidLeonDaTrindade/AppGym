<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('foods', function (Blueprint $table): void {
            $table->index(['trainer_id', 'brand'], 'foods_trainer_brand_index');
            $table->index(['trainer_id', 'source'], 'foods_trainer_source_index');
            $table->index(['trainer_id', 'is_active'], 'foods_trainer_active_index');
            $table->index(['trainer_id', 'external_id'], 'foods_trainer_external_index');
        });
    }

    public function down(): void
    {
        Schema::table('foods', function (Blueprint $table): void {
            $table->dropIndex('foods_trainer_brand_index');
            $table->dropIndex('foods_trainer_source_index');
            $table->dropIndex('foods_trainer_active_index');
            $table->dropIndex('foods_trainer_external_index');
        });
    }
};
