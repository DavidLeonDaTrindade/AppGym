<?php

namespace Tests\Feature;

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
}
