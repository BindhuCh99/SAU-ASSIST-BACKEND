<?php

namespace Tests\Feature;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileCreationCrud extends TestCase
{
    use RefreshDatabase;

    /**
     * Test creating user profile info.
     */
    public function test_create_user_profile(): void
    {
        $user = User::factory()->create();
    
        $response = $this->actingAs($user)
                         ->post('/profile', [
                             'name' => 'John Doe',
                             'email' => 'john.doe@example.com',
                             'phone' => '123-456-7890',
                         ]);
    
        $response->assertStatus(201); // Assuming 201 indicates successful creation
        $this->assertDatabaseHas('profiles', [
            'user_id' => $user->id,
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'phone' => '123-456-7890',
        ]);
    }
    

    /**
     * Test retrieving user profile.
     */
    public function test_retrieve_user_profile(): void
{
    $user = User::factory()->create();
    $profile = Profile::factory()->create(['user_id' => $user->id]);

    $response = $this->actingAs($user)->get('/profile');

    $response->assertStatus(200); // Assuming 200 indicates successful retrieval
    $response->assertJson([
        'id' => $profile->id,
        'name' => $profile->name,
        'email' => $profile->email,
        'phone' => $profile->phone,
    ]);
}


    /**
     * Test editing user profile.
     */
    public function test_edit_user_profile(): void
{
    $user = User::factory()->create();
    $profile = Profile::factory()->create(['user_id' => $user->id]);

    $response = $this->actingAs($user)
                     ->put('/profile', [
                         'name' => 'Updated Name',
                         'email' => 'updated.email@example.com',
                         'phone' => '987-654-3210',
                     ]);

    $response->assertStatus(200); // Assuming 200 indicates successful update
    $this->assertDatabaseHas('profiles', [
        'id' => $profile->id,
        'name' => 'Updated Name',
        'email' => 'updated.email@example.com',
        'phone' => '987-654-3210',
    ]);
}


    /**
     * Test deleting user profile.
     */
    public function test_delete_user_profile(): void
{
    $user = User::factory()->create();
    $profile = Profile::factory()->create(['user_id' => $user->id]);

    $response = $this->actingAs($user)->delete('/profile');

    $response->assertStatus(200); // Assuming 200 indicates successful deletion
    $this->assertDeleted($profile);
}

}
