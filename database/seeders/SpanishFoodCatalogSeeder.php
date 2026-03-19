<?php

namespace Database\Seeders;

use App\Models\Food;
use App\Models\User;
use Illuminate\Database\Seeder;

class SpanishFoodCatalogSeeder extends Seeder
{
    /**
     * @return array<int, array<string, int|float|string>>
     */
    public static function catalog(): array
    {
        return [
            ['name' => 'Arroz blanco cocido', 'calories_kcal' => 130, 'protein_g' => 2.4, 'carbs_g' => 28.2, 'fat_g' => 0.3, 'fiber_g' => 0.4, 'sugar_g' => 0.1, 'sodium_mg' => 1],
            ['name' => 'Pechuga de pollo', 'calories_kcal' => 165, 'protein_g' => 31.0, 'carbs_g' => 0.0, 'fat_g' => 3.6, 'fiber_g' => 0.0, 'sugar_g' => 0.0, 'sodium_mg' => 74],
            ['name' => 'Salmón', 'calories_kcal' => 208, 'protein_g' => 20.0, 'carbs_g' => 0.0, 'fat_g' => 13.0, 'fiber_g' => 0.0, 'sugar_g' => 0.0, 'sodium_mg' => 59],
            ['name' => 'Avena', 'calories_kcal' => 389, 'protein_g' => 16.9, 'carbs_g' => 66.3, 'fat_g' => 6.9, 'fiber_g' => 10.6, 'sugar_g' => 0.9, 'sodium_mg' => 2],
            ['name' => 'Plátano', 'calories_kcal' => 89, 'protein_g' => 1.1, 'carbs_g' => 22.8, 'fat_g' => 0.3, 'fiber_g' => 2.6, 'sugar_g' => 12.2, 'sodium_mg' => 1],
            ['name' => 'Huevos', 'calories_kcal' => 143, 'protein_g' => 12.6, 'carbs_g' => 0.7, 'fat_g' => 9.5, 'fiber_g' => 0.0, 'sugar_g' => 0.4, 'sodium_mg' => 140],
            ['name' => 'Brócoli', 'calories_kcal' => 35, 'protein_g' => 2.4, 'carbs_g' => 7.2, 'fat_g' => 0.4, 'fiber_g' => 3.3, 'sugar_g' => 1.4, 'sodium_mg' => 41],
            ['name' => 'Yogur griego natural', 'calories_kcal' => 97, 'protein_g' => 9.0, 'carbs_g' => 3.9, 'fat_g' => 5.0, 'fiber_g' => 0.0, 'sugar_g' => 3.6, 'sodium_mg' => 36],
            ['name' => 'Patata cocida', 'calories_kcal' => 87, 'protein_g' => 1.9, 'carbs_g' => 20.1, 'fat_g' => 0.1, 'fiber_g' => 1.8, 'sugar_g' => 0.9, 'sodium_mg' => 4],
            ['name' => 'Batata', 'calories_kcal' => 86, 'protein_g' => 1.6, 'carbs_g' => 20.1, 'fat_g' => 0.1, 'fiber_g' => 3.0, 'sugar_g' => 4.2, 'sodium_mg' => 55],
            ['name' => 'Atún al natural', 'calories_kcal' => 116, 'protein_g' => 25.5, 'carbs_g' => 0.0, 'fat_g' => 0.8, 'fiber_g' => 0.0, 'sugar_g' => 0.0, 'sodium_mg' => 247],
            ['name' => 'Aceite de oliva virgen extra', 'calories_kcal' => 884, 'protein_g' => 0.0, 'carbs_g' => 0.0, 'fat_g' => 100.0, 'fiber_g' => 0.0, 'sugar_g' => 0.0, 'sodium_mg' => 2],
            ['name' => 'Aguacate', 'calories_kcal' => 160, 'protein_g' => 2.0, 'carbs_g' => 8.5, 'fat_g' => 14.7, 'fiber_g' => 6.7, 'sugar_g' => 0.7, 'sodium_mg' => 7],
            ['name' => 'Pan integral', 'calories_kcal' => 247, 'protein_g' => 12.4, 'carbs_g' => 41.0, 'fat_g' => 4.2, 'fiber_g' => 7.0, 'sugar_g' => 6.0, 'sodium_mg' => 430],
            ['name' => 'Pasta cocida', 'calories_kcal' => 157, 'protein_g' => 5.8, 'carbs_g' => 30.9, 'fat_g' => 0.9, 'fiber_g' => 1.8, 'sugar_g' => 0.6, 'sodium_mg' => 1],
            ['name' => 'Lentejas cocidas', 'calories_kcal' => 116, 'protein_g' => 9.0, 'carbs_g' => 20.1, 'fat_g' => 0.4, 'fiber_g' => 7.9, 'sugar_g' => 1.8, 'sodium_mg' => 2],
            ['name' => 'Garbanzos cocidos', 'calories_kcal' => 164, 'protein_g' => 8.9, 'carbs_g' => 27.4, 'fat_g' => 2.6, 'fiber_g' => 7.6, 'sugar_g' => 4.8, 'sodium_mg' => 7],
            ['name' => 'Merluza', 'calories_kcal' => 82, 'protein_g' => 18.3, 'carbs_g' => 0.0, 'fat_g' => 0.7, 'fiber_g' => 0.0, 'sugar_g' => 0.0, 'sodium_mg' => 74],
            ['name' => 'Ternera magra', 'calories_kcal' => 176, 'protein_g' => 29.0, 'carbs_g' => 0.0, 'fat_g' => 6.0, 'fiber_g' => 0.0, 'sugar_g' => 0.0, 'sodium_mg' => 72],
            ['name' => 'Queso fresco batido 0%', 'calories_kcal' => 46, 'protein_g' => 8.0, 'carbs_g' => 3.6, 'fat_g' => 0.2, 'fiber_g' => 0.0, 'sugar_g' => 3.6, 'sodium_mg' => 45],
            ['name' => 'Almendras', 'calories_kcal' => 579, 'protein_g' => 21.2, 'carbs_g' => 21.6, 'fat_g' => 49.9, 'fiber_g' => 12.5, 'sugar_g' => 4.4, 'sodium_mg' => 1],
            ['name' => 'Nueces', 'calories_kcal' => 654, 'protein_g' => 15.2, 'carbs_g' => 13.7, 'fat_g' => 65.2, 'fiber_g' => 6.7, 'sugar_g' => 2.6, 'sodium_mg' => 2],
            ['name' => 'Manzana', 'calories_kcal' => 52, 'protein_g' => 0.3, 'carbs_g' => 13.8, 'fat_g' => 0.2, 'fiber_g' => 2.4, 'sugar_g' => 10.4, 'sodium_mg' => 1],
            ['name' => 'Tomate', 'calories_kcal' => 18, 'protein_g' => 0.9, 'carbs_g' => 3.9, 'fat_g' => 0.2, 'fiber_g' => 1.2, 'sugar_g' => 2.6, 'sodium_mg' => 5],
            ['name' => 'Lechuga', 'calories_kcal' => 15, 'protein_g' => 1.4, 'carbs_g' => 2.9, 'fat_g' => 0.2, 'fiber_g' => 1.3, 'sugar_g' => 0.8, 'sodium_mg' => 28],
        ];
    }

    public function run(): void
    {
        $trainer = User::query()->firstOrCreate(
            ['email' => 'trainer@appgym.local'],
            [
                'name' => 'Entrenador Principal',
                'password' => 'password',
                'role' => User::ROLE_TRAINER,
                'is_active' => true,
            ]
        );

        foreach (self::catalog() as $food) {
            Food::query()->updateOrCreate(
                [
                    'trainer_id' => $trainer->id,
                    'name' => $food['name'],
                ],
                array_merge($food, [
                    'trainer_id' => $trainer->id,
                    'serving_reference' => '100 g',
                    'source' => 'catalogo_es',
                    'notes' => 'Catálogo local en español para AppGym.',
                    'is_active' => true,
                ])
            );
        }
    }
}
