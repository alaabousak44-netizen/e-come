<?php

namespace Tests\Feature;

use App\Models\TravelRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TravelRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_travel_request_can_be_submitted_and_saved(): void
    {
        $payload = [
            'name' => 'Alaa Ben',
            'email' => 'alaa@example.com',
            'destination_interest' => 'Bali',
            'message' => 'Please help me plan a 5-day trip.',
        ];

        $response = $this->post(route('travel-requests.store'), $payload);

        $response->assertRedirect(route('travel-requests.sent'));
        $response->assertSessionHas('request_reference');
        $this->assertDatabaseHas('travel_requests', [
            'email' => 'alaa@example.com',
            'destination_interest' => 'Bali',
        ]);
        $this->assertDatabaseCount('travel_requests', 1);
        $this->assertEquals('Alaa Ben', TravelRequest::first()->name);
    }
}
