<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CustomerControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $token;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a user and obtain a token for authenticated requests
        $user = User::factory()->create([
            'password' => Hash::make('password@123'),
        ]);

        // Ensure Passport is installed and the personal access client is created
        $this->ensurePassportClientExists();

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password@123',
        ]);

        $response->assertStatus(Response::HTTP_OK);

        $this->token = $response->json('data.token');
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
    public function it_can_get_all_customers()
    {
        $response = $this->withHeaders([
            'Authorization' => "Bearer $this->token",
        ])->getJson('/api/customers');

        $response->assertStatus(Response::HTTP_OK);
    }

    /** @test */
    public function it_can_create_a_customer()
    {
        $response = $this->withHeaders([
            'Authorization' => "Bearer $this->token",
        ])->postJson('/api/customers', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'age' => 30,
            'dob' => '1994-09-01',
            'email' => 'john.doe@example.com',
        ]);

        $response->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseHas('customers', [
            'email' => 'john.doe@example.com',
        ]);
    }

    /** @test */
    public function it_can_show_a_customer()
    {
        $customer = Customer::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => "Bearer $this->token",
        ])->getJson('/api/customers/' . $customer->id);

        $response->assertStatus(Response::HTTP_OK);
    }

    /** @test */
    public function it_can_update_a_customer()
    {
        $customer = Customer::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => "Bearer $this->token",
        ])->putJson('/api/customers/' . $customer->id, [
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'age' => 28,
            'dob' => '1996-05-15',
            'email' => 'jane.doe@example.com',
        ]);

        $response->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseHas('customers', [
            'email' => 'jane.doe@example.com',
        ]);
    }

    /** @test */
    public function it_can_delete_a_customer()
    {
        $customer = Customer::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => "Bearer $this->token",
        ])->deleteJson('/api/customers/' . $customer->id);

        $response->assertStatus(Response::HTTP_NO_CONTENT);

        $this->assertDatabaseMissing('customers', [
            'id' => $customer->id,
        ]);
    }
}
