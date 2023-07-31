<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetAuthUserTest extends TestCase
{
    use RefreshDatabase;

    // vendor/bin/phpunit --filter authenticated_user_can_be_fetched
    /** @test */
    public function authenticated_user_can_be_fetched()
    {
        $this->withExceptionHandling();
        $this->actingAs($user = User::factory()->create(), 'api');

        $response = $this->get('/api/auth-user');

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'attributes' => [
                        'name' => $user->name,
                    ],
                    'user_id' => $user->id,
                ],
                'links' => [
                    'self' => url('/users/'.$user->id),
                ]
            ]);
    }
}
