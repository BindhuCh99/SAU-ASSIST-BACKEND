<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use PHPUnit\Framework\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A test to check if a user can be authenticated.
     */
    public function test_user_authentication(): void
    {
        // Create a user for testing purposes
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        // Attempt to authenticate the user
        $authenticated = Auth::attempt([
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $this->assertTrue($authenticated, 'User authentication failed.');
    }
}

