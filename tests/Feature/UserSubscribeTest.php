<?php

namespace Tests\Feature;

use App\Models\Website;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserSubscribeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_subscirbe_to_a_website()
    {
        $this->withoutExceptionHandling();

        $website = Website::factory()->create();

        $response = $this->postJson("/api/websites/{$website->id}/subscribe", [
            'email' => 'johndoe@domain.tld'
        ]);

        $response->assertCreated();

        $this->assertDatabaseCount('users', 1)
            ->assertDatabaseHas('users', [
                'email' => 'johndoe@domain.tld',
                'website_id' => $website->id
            ]);
    }
}
