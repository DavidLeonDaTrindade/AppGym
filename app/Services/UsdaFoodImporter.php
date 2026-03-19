<?php

namespace App\Services;

use App\Models\Food;
use App\Models\User;
use Illuminate\Http\Client\Factory as HttpFactory;
use Illuminate\Support\Arr;
use RuntimeException;

class UsdaFoodImporter
{
    public function __construct(
        private readonly HttpFactory $http,
    ) {
    }

    /**
     * @return array{imported:int, skipped:int, queries:array<int, string>, rate_limited:bool}
     */
    public function importForTrainer(User $trainer, array $queries, bool $overwrite = false): array
    {
        $apiKey = config('services.usda_food_data_central.key') ?: 'DEMO_KEY';
        $baseUrl = rtrim((string) config('services.usda_food_data_central.base_url'), '/');

        if ($baseUrl === '') {
            throw new RuntimeException('La URL base de USDA no está configurada.');
        }

        $queries = array_values(array_filter(array_map('trim', $queries)));

        if ($queries === []) {
            $queries = $this->defaultQueries();
        }

        $imported = 0;
        $skipped = 0;
        $rateLimited = false;

        foreach ($queries as $query) {
            $response = $this->http->acceptJson()->get($baseUrl . '/foods/search', [
                'api_key' => $apiKey,
                'query' => $query,
                'pageSize' => 1,
            ]);

            if ($response->status() === 429) {
                $rateLimited = true;

                break;
            }

            $response->throw();

            $food = Arr::first($response->json('foods', []));

            if (! $food) {
                $skipped++;

                continue;
            }

            $attributes = $this->mapFood($food, $trainer);

            $record = Food::query()->where([
                'trainer_id' => $trainer->id,
                'external_id' => $attributes['external_id'],
            ])->first();

            if ($record && ! $overwrite) {
                $skipped++;

                continue;
            }

            Food::query()->updateOrCreate(
                [
                    'trainer_id' => $trainer->id,
                    'external_id' => $attributes['external_id'],
                ],
                $attributes,
            );

            $imported++;
        }

        return [
            'imported' => $imported,
            'skipped' => $skipped,
            'queries' => $queries,
            'rate_limited' => $rateLimited,
        ];
    }

    /**
     * @param  array<string, mixed>  $food
     * @return array<string, mixed>
     */
    private function mapFood(array $food, User $trainer): array
    {
        $nutrients = collect($food['foodNutrients'] ?? []);
        $servingSize = $food['servingSize'] ?? null;
        $servingUnit = $food['servingSizeUnit'] ?? 'g';

        return [
            'trainer_id' => $trainer->id,
            'name' => $food['description'] ?? 'Alimento USDA',
            'brand' => $food['brandOwner'] ?? $food['brandName'] ?? null,
            'serving_reference' => $servingSize
                ? trim((string) $servingSize . ' ' . $servingUnit)
                : '100 g',
            'calories_kcal' => $this->nutrientValue($nutrients, ['Energy', 'Energy (Atwater General Factors)']),
            'protein_g' => $this->nutrientValue($nutrients, ['Protein']),
            'carbs_g' => $this->nutrientValue($nutrients, ['Carbohydrate, by difference']),
            'fat_g' => $this->nutrientValue($nutrients, ['Total lipid (fat)']),
            'fiber_g' => $this->nutrientValue($nutrients, ['Fiber, total dietary']),
            'sugar_g' => $this->nutrientValue($nutrients, ['Sugars, total including NLEA']),
            'sodium_mg' => $this->nutrientValue($nutrients, ['Sodium, Na']),
            'notes' => $food['foodCategory'] ?? $food['dataType'] ?? null,
            'source' => 'usda',
            'external_id' => (string) ($food['fdcId'] ?? ''),
            'is_active' => true,
        ];
    }

    private function nutrientValue($nutrients, array $names): float
    {
        $match = $nutrients->first(function (array $nutrient) use ($names): bool {
            return in_array($nutrient['nutrientName'] ?? '', $names, true);
        });

        return round((float) ($match['value'] ?? 0), 2);
    }

    /**
     * @return array<int, string>
     */
    private function defaultQueries(): array
    {
        return [
            'chicken breast',
            'white rice cooked',
            'oats',
            'banana',
            'salmon',
            'eggs',
            'broccoli',
            'greek yogurt plain',
            'potato',
            'tuna',
            'olive oil',
            'avocado',
        ];
    }
}
