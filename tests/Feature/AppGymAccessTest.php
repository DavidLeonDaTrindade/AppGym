<?php

namespace Tests\Feature;

use App\Models\BodyMeasurement;
use App\Models\ClientDiet;
use App\Models\ClientRoutine;
use App\Models\Diet;
use App\Models\Routine;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AppGymAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_inactive_user_cannot_log_in(): void
    {
        $user = User::factory()->create([
            'email' => 'inactive@example.com',
            'password' => 'password',
            'is_active' => false,
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_trainer_is_redirected_to_admin_after_login(): void
    {
        $trainer = User::factory()->create([
            'email' => 'trainer@example.com',
            'password' => 'password',
            'role' => User::ROLE_TRAINER,
        ]);

        $response = $this->post('/login', [
            'email' => $trainer->email,
            'password' => 'password',
        ]);

        $response->assertRedirect('/admin');
        $this->assertAuthenticatedAs($trainer);
    }

    public function test_client_can_view_only_their_current_plan(): void
    {
        $trainer = User::factory()->create([
            'role' => User::ROLE_TRAINER,
            'email' => 'coach@example.com',
        ]);

        $client = User::factory()->create([
            'trainer_id' => $trainer->id,
            'role' => User::ROLE_CLIENT,
        ]);

        $routine = Routine::create([
            'trainer_id' => $trainer->id,
            'title' => 'Fuerza base',
            'description' => 'Rutina full body',
            'is_active' => true,
        ]);

        $diet = Diet::create([
            'trainer_id' => $trainer->id,
            'title' => 'Definición',
            'summary' => 'Plan semanal',
            'content' => 'Proteína alta y verduras.',
            'is_active' => true,
        ]);

        ClientRoutine::create([
            'trainer_id' => $trainer->id,
            'client_id' => $client->id,
            'routine_id' => $routine->id,
            'is_active' => true,
        ]);

        ClientDiet::create([
            'trainer_id' => $trainer->id,
            'client_id' => $client->id,
            'diet_id' => $diet->id,
            'is_active' => true,
        ]);

        $response = $this->actingAs($client)->get('/dashboard');

        $response->assertOk();
        $response->assertSee('Fuerza base');
        $response->assertSee('Definición');
    }

    public function test_client_can_store_measurements_and_sync_current_metrics(): void
    {
        $client = User::factory()->create([
            'role' => User::ROLE_CLIENT,
            'weight_kg' => 100,
            'body_fat_percentage' => 30,
            'muscle_mass_kg' => 35,
        ]);

        $response = $this->actingAs($client)->post('/mi-progreso/mediciones', [
            'measured_at' => '2026-03-17',
            'age' => 30,
            'training_years' => 4,
            'height_cm' => 180,
            'weight_kg' => 94,
            'body_mass_index' => 0,
            'muscle_mass_index' => 41,
            'body_fat_percentage' => 22,
            'muscle_mass_kg' => 39,
            'goal_weight_kg' => 88,
            'waist_cm' => 90,
            'notes' => 'Buen progreso',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('body_measurements', [
            'client_id' => $client->id,
            'weight_kg' => 94,
            'body_fat_percentage' => 22,
            'muscle_mass_kg' => 39,
        ]);

        $client->refresh();

        $this->assertSame('94.00', $client->weight_kg);
        $this->assertSame('22.00', $client->body_fat_percentage);
        $this->assertSame('39.00', $client->muscle_mass_kg);
    }

    public function test_dashboard_shows_progress_area_for_client(): void
    {
        $client = User::factory()->create([
            'role' => User::ROLE_CLIENT,
            'weight_kg' => 94,
            'body_fat_percentage' => 22,
            'muscle_mass_kg' => 39,
        ]);

        BodyMeasurement::create([
            'client_id' => $client->id,
            'measured_at' => '2026-02-17',
            'age' => 30,
            'training_years' => 4,
            'height_cm' => 180,
            'weight_kg' => 100,
            'body_mass_index' => 30.86,
            'muscle_mass_index' => 38,
            'body_fat_percentage' => 30,
            'muscle_mass_kg' => 35,
            'goal_weight_kg' => 88,
            'waist_cm' => 99,
        ]);

        BodyMeasurement::create([
            'client_id' => $client->id,
            'measured_at' => '2026-03-17',
            'age' => 30,
            'training_years' => 4,
            'height_cm' => 180,
            'weight_kg' => 94,
            'body_mass_index' => 29.01,
            'muscle_mass_index' => 41,
            'body_fat_percentage' => 22,
            'muscle_mass_kg' => 39,
            'goal_weight_kg' => 88,
            'waist_cm' => 90,
        ]);

        $response = $this->actingAs($client)->get('/dashboard');

        $response->assertOk();
        $response->assertSee('Tu evolución');
        $response->assertSee('94.0 kg');
        $response->assertSee('39.0 kg');
    }
}
