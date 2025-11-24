<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_usuario_pode_se_registrar()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Teste User',
            'email' => 'teste@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'tipo' => 'doador',
        ]);

        // O registro retorna apenas o usuário e mensagem, sem token
        $response->assertStatus(201)
                 ->assertJsonStructure(['user', 'message']);

        $this->assertDatabaseHas('users', ['email' => 'teste@example.com']);
    }

    public function test_usuario_pode_fazer_login()
    {
        $user = User::factory()->create([
            'email' => 'login@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'login@example.com',
            'password' => 'password123',
        ]);

        // O login retorna access_token
        $response->assertStatus(200)
                 ->assertJsonStructure(['user', 'access_token']);
    }

    public function test_usuario_nao_pode_logar_com_senha_errada()
    {
        $user = User::factory()->create([
            'email' => 'erro@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'erro@example.com',
            'password' => 'senhaerrada',
        ]);

        $response->assertStatus(401);
    }
}
