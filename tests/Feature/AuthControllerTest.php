<?php
namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public $mockConsoleOutput = false;

    protected function setUp(): void
    {
        parent::setUp();

        // Ensure Passport is installed and the personal access client is created
        $this->ensurePassportClientExists();
    }

    protected function ensurePassportClientExists()
    {
        // Check if personal access client exists
        $clientExists = DB::table('oauth_clients')
            ->where('password_client', false)
            ->where('personal_access_client', true)
            ->exists();

        if (!$clientExists) {
            // Run Passport installation without mocking Artisan
            Artisan::call('passport:client', ['--personal' => true, '--no-interaction' => true]);
        }
    }

    /** @test */
    public function it_can_register_a_user()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'password' => 'password@123',
            'password_confirmation' => 'password@123',
        ]);

        $response->assertStatus(Response::HTTP_CREATED);

        $this->assertDatabaseHas('users', [
            'email' => 'testuser@example.com',
        ]);
    }

    /** @test */
    public function it_can_login_a_user()
    {
        $user = User::factory()->create([
            'password' => Hash::make('password@123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password@123',
        ]);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'token',
                ],
            ]);

        $this->assertAuthenticated();
    }

    /** @test */
    public function it_can_logout_a_user()
    {
        $user = User::factory()->create([
            'password' => Hash::make('password@123'),
        ]);

        // Simulate login
        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password@123',
        ]);

        $response->assertStatus(Response::HTTP_OK);

        $token = $response->json('data.token');

        $this->withHeaders([
            'Authorization' => "Bearer $token",
        ])->postJson('/api/logout')
            ->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'message' => 'Logout successful',
            ]);
    }
}
