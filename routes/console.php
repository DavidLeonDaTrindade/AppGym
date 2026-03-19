<?php

use App\Models\User;
use App\Services\AesanFoodImporter;
use App\Services\UsdaFoodImporter;
use Database\Seeders\SpanishFoodCatalogSeeder;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('foods:import-usda {trainer=trainer@appgym.local} {--q=*} {--overwrite}', function (UsdaFoodImporter $importer, string $trainer) {
    $trainerModel = User::query()
        ->where('email', $trainer)
        ->orWhere('id', $trainer)
        ->first();

    if (! $trainerModel || ! $trainerModel->isTrainer()) {
        $this->error('No se encontró un entrenador válido para importar alimentos.');

        return self::FAILURE;
    }

    $result = $importer->importForTrainer(
        $trainerModel,
        $this->option('q'),
        (bool) $this->option('overwrite'),
    );

    $this->info('Importación USDA completada.');
    $this->line('Entrenador: ' . $trainerModel->email);
    $this->line('Consultas: ' . implode(', ', $result['queries']));
    $this->line('Importados: ' . $result['imported']);
    $this->line('Saltados: ' . $result['skipped']);

    if ($result['rate_limited']) {
        $this->warn('USDA ha devuelto rate limit. Lo ya importado se ha guardado, pero para lotes grandes conviene usar una API key propia en vez de DEMO_KEY.');
    }

    return self::SUCCESS;
})->purpose('Importa alimentos desde USDA FoodData Central al catálogo local');

Artisan::command('foods:reset-spanish-catalog {trainer=trainer@appgym.local}', function (string $trainer) {
    $trainerModel = User::query()
        ->where('email', $trainer)
        ->orWhere('id', $trainer)
        ->first();

    if (! $trainerModel || ! $trainerModel->isTrainer()) {
        $this->error('No se encontró un entrenador válido para reconstruir el catálogo español.');

        return self::FAILURE;
    }

    \App\Models\Food::query()
        ->where('trainer_id', $trainerModel->id)
        ->delete();

    foreach (SpanishFoodCatalogSeeder::catalog() as $food) {
        \App\Models\Food::query()->create(array_merge($food, [
            'trainer_id' => $trainerModel->id,
            'serving_reference' => '100 g',
            'source' => 'catalogo_es',
            'notes' => 'Catálogo local en español para AppGym.',
            'is_active' => true,
        ]));
    }

    $this->info('Catálogo español cargado correctamente.');
    $this->line('Total alimentos: ' . \App\Models\Food::query()->where('trainer_id', $trainerModel->id)->count());

    return self::SUCCESS;
})->purpose('Elimina el catálogo actual y carga un catálogo local en español');

Artisan::command('foods:import-aesan {trainer=trainer@appgym.local} {--file=/var/www/html/storage/app/private/aesan_foods.xlsx} {--replace}', function (AesanFoodImporter $importer, string $trainer) {
    $trainerModel = User::query()
        ->where('email', $trainer)
        ->orWhere('id', $trainer)
        ->first();

    if (! $trainerModel || ! $trainerModel->isTrainer()) {
        $this->error('No se encontró un entrenador válido para importar AESAN.');

        return self::FAILURE;
    }

    $result = $importer->importForTrainer(
        $trainerModel,
        (string) $this->option('file'),
        (bool) $this->option('replace'),
    );

    $this->info('Importación AESAN completada.');
    $this->line('Fichero: ' . $result['file']);
    $this->line('Importados: ' . $result['imported']);

    return self::SUCCESS;
})->purpose('Importa alimentos desde el fichero oficial de AESAN');
