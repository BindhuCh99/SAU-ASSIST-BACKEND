<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ChatbotTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * Test if the chatbot can receive prompts through HTTP and respond.
     */
    public function test_chatbot_receives_prompts_and_responds(): void
    {
        // Simulate a prompt sent to the chatbot
        $prompt = $this->faker->sentence;

        // Mock a response from the chatbot
        $responseText = 'Hello, you said: ' . $prompt;

        // Mock the HTTP request to the chatbot endpoint
        Http::fake([
            'your-chatbot-endpoint' => Http::response([
                'response' => $responseText,
            ], 200),
        ]);

        // Send a POST request to the chatbot endpoint with the prompt
        $response = $this->postJson('/chatbot', [
            'prompt' => $prompt,
        ]);

        // Assert that the response is successful (HTTP status code 200)
        $response->assertStatus(200);

        // Assert that the chatbot responded with the expected text
        $response->assertJson([
            'response' => $responseText,
        ]);
    }
}
