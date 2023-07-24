<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostToTimelineTest extends TestCase
{
//    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    /** @test  */
    public function a_user_can_post_a_text_post(): void
    {
        $this->withExceptionHandling();
        $this->actingAs($user = User::factory()->create(), 'api');
        $response = $this->post('/api/posts', [
            'data' => [
                'type' => 'posts',
                'attributes' => [
                    'body' => 'Testing Body'
                ]
            ]
        ]);

        $post = \App\Models\Post::first();

        $response->assertStatus(201)
            ->assertJson([
                'data' => [
                    'type' => 'posts',
                    'post_id' => $post->id,
                    'attributes' => [
                        'body' => 'Testing Body',

                    ]
                ]
            ]);
    }
}
