<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Website;
use App\Notifications\NewPostNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class CreatePostTest extends TestCase
{
    use RefreshDatabase;

    /** @test */

    public function a_website_can_create_post()
    {
        $this->withoutExceptionHandling();

        Notification::fake();

        $website = Website::factory()->has(User::factory()->count(15))->create();

        $users = $website->users;

        $otherUsers = User::factory()->for(Website::factory())->count(10)->create();

        // dd($website->users);

        $response = $this->postJson("/api/websites/{$website->id}/posts", [
            'title' => 'Lorem ipsum dolor sit amet consectetur',
            'body' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Veniam natus ullam odio, molestiae ipsa cumque sequi.'
        ]);

        $response->assertCreated()
            ->assertJson([
                'data' => [
                    'title' => 'Lorem ipsum dolor sit amet consectetur',
                    'body' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Veniam natus ullam odio, molestiae ipsa cumque sequi.'
                ]
            ]);

        Notification::assertSentTo($users, NewPostNotification::class);

        Notification::assertNotSentTo($otherUsers, NewPostNotification::class);

        $this->assertDatabaseCount('posts', 1)
            ->assertDatabaseCount('websites', 2)
            ->assertDatabaseHas('posts', [
                'website_id' => $website->id,
                'title' => 'Lorem ipsum dolor sit amet consectetur'
            ]);
    }
}
