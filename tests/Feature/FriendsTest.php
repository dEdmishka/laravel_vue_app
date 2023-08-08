<?php

namespace Tests\Feature;

use App\Models\Friend;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FriendsTest extends TestCase
{
    // vendor/bin/phpunit --filter a_user_can_send_a_friend_request
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    /** @test */
    public function a_user_can_send_a_friend_request()
    {
        $this->withExceptionHandling();

        $this->actingAs($user = User::factory()->create(), 'api');
        $anotherUser = User::factory()->create();

        $response = $this->post('/api/friend-request', [
            'friend_id' => $anotherUser->id,
        ])->assertStatus(200);

        $friendRequest = Friend::first();

        $this->assertNotNull($friendRequest);

        $this->assertEquals($anotherUser->id, $friendRequest->friend_id);
        $this->assertEquals($user->id, $friendRequest->user_id);

        $response->assertJson([
            'data' => [
                'type' => 'friend-request',
                'friend_request_id' => $friendRequest->id,
                'attributes' => [
                    'confirmed_at' => null,
                ]
            ],
            'links' => [
                'self' => url('/users/' . $anotherUser->id),
            ]
        ]);
    }

    // vendor/bin/phpunit --filter only_valid_users_can_be_friend_requested

    /** @test */
    public function only_valid_users_can_be_friend_requested()
    {
        $this->withExceptionHandling();

        $this->actingAs($user = User::factory()->create(), 'api');

        $response = $this->post('/api/friend-request', [
            'friend_id' => 123,
        ])->assertStatus(404);

        $this->assertNull(Friend::first());

        $response->assertJson([
            'errors' => [
                'code' => 404,
                'title' => "User not found",
                'detail' => 'Unable to locate the user with the given information'
            ]
        ]);
    }

    // vendor/bin/phpunit --filter friend_request_can_be_accepted

    /** @test */
    public function friend_request_can_be_accepted()
    {
        $this->withExceptionHandling();

        $this->actingAs($user = User::factory()->create(), 'api');
        $anotherUser = User::factory()->create();

        $this->post('/api/friend-request', [
            'friend_id' => $anotherUser->id,
        ])->assertStatus(200);

        $response = $this->actingAs($anotherUser, 'api')
            ->post('/api/friend-request-response', [
                'user_id' => $user->id,
                'status' => 1,
            ])->assertStatus(200);

        $friendRequest = Friend::first();
        $this->assertNotNull($friendRequest->confirmed_at);
        $this->assertInstanceOf(Carbon::class, $friendRequest->confirmed_at);
        $this->assertEquals(now()->startOfSecond(), $friendRequest->confirmed_at);
        $this->assertEquals(1, $friendRequest->status);

        $response->assertJson([
            'data' => [
                'type' => 'friend-request',
                'friend_request_id' => $friendRequest->id,
                'attributes' => [
                    'confirmed_at' => $friendRequest->confirmed_at->diffForHumans(),
                ]
            ],
            'links' => [
                'self' => url('/users/' . $anotherUser->id),
            ]
        ]);
    }

    // vendor/bin/phpunit --filter only_valid_friend_request_can_be_accepted

    /** @test */
    public function only_valid_friend_request_can_be_accepted()
    {
        $anotherUser = User::factory()->create();

        $response = $this->actingAs($anotherUser, 'api')
            ->post('/api/friend-request-response', [
                'user_id' => 123,
                'status' => 1,
            ])->assertStatus(404);

        $this->assertNull(Friend::first());

        $response->assertJson([
            'errors' => [
                'code' => 404,
                'title' => "Friend Request not found",
                'detail' => 'Unable to locate the friend request with the given information'
            ]
        ]);
    }

    // vendor/bin/phpunit --filter only_the_recipient_can_accept_a_friend_request

    /** @test */
    public function only_the_recipient_can_accept_a_friend_request()
    {
        $this->withExceptionHandling();

        $this->actingAs($user = User::factory()->create(), 'api');
        $anotherUser = User::factory()->create();

        $this->post('/api/friend-request', [
            'friend_id' => $anotherUser->id,
        ])->assertStatus(200);

        $response = $this->actingAs(User::factory()->create(), 'api')
            ->post('/api/friend-request-response', [
                'user_id' => $user->id,
                'status' => 1,
            ])->assertStatus(404);

        $friendRequest = Friend::first();
        $this->assertNull($friendRequest->confirmed_at);
        $this->assertNull($friendRequest->status);
        $response->assertJson([
            'errors' => [
                'code' => 404,
                'title' => "Friend Request not found",
                'detail' => 'Unable to locate the friend request with the given information'
            ]
        ]);
    }

    // vendor/bin/phpunit --filter a_friend_id_is_required_for_friend_requests

    /** @test */
    public function a_friend_id_is_required_for_friend_requests()
    {
        $response = $this->actingAs($user = User::factory()->create(), 'api')
            ->post('/api/friend-request', [
                'friend_id' => '',
            ])->assertStatus(422);

        $responseString = json_decode($response->getContent(), true);
//        dd($responseString);
//        dd($response->getContent());
        $this->assertArrayHasKey('friend_id', $responseString['errors']['meta']);
    }

    // vendor/bin/phpunit --filter a_user_id_and_status_is_required_for_friend_request_responses

    /** @test */
    public function a_user_id_and_status_is_required_for_friend_request_responses()
    {
        $response = $this->actingAs($user = User::factory()->create(), 'api')
            ->post('/api/friend-request-response', [
                'user_id' => '',
                'status' => '',
            ])->assertStatus(422);
        $responseString = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('user_id', $responseString['errors']['meta']);
        $this->assertArrayHasKey('status', $responseString['errors']['meta']);
    }

    // vendor/bin/phpunit --filter a_friendship_is_retrieved_when_fetching_the_profile

    /** @test */
    public function a_friendship_is_retrieved_when_fetching_the_profile()
    {
        $this->actingAs($user = User::factory()->create(), 'api');
        $anotherUser = User::factory()->create();
        $friendRequest = Friend::create([
            'user_id' => $user->id,
            'friend_id' => $anotherUser->id,
            'confirmed_at' => now()->subDay(),
            'status' => 1,
        ]);

        $this->get('/api/users/' . $anotherUser->id)
            ->assertStatus(200)
            ->assertJson(
                [
                    'data' => [
                        'attributes' => [
                            'friendship' => [
                                'data' => [
                                    'friend_request_id' => $friendRequest->id,
                                    'attributes' => [
                                        'confirmed_at' => '1 day ago',
                                    ]
                                ]
                            ]
                        ]
                    ],
                ]
            );
    }

    // vendor/bin/phpunit --filter an_inverse_friendship_is_retrieved_when_fetching_the_profile

    /** @test */
    public function an_inverse_friendship_is_retrieved_when_fetching_the_profile()
    {
        $this->actingAs($user = User::factory()->create(), 'api');
        $anotherUser = User::factory()->create();
        $friendRequest = Friend::create([
            'friend_id' => $user->id,
            'user_id' => $anotherUser->id,
            'confirmed_at' => now()->subDay(),
            'status' => 1,
        ]);

        $this->get('/api/users/' . $anotherUser->id)
            ->assertStatus(200)
            ->assertJson(
                [
                    'data' => [
                        'attributes' => [
                            'friendship' => [
                                'data' => [
                                    'friend_request_id' => $friendRequest->id,
                                    'attributes' => [
                                        'confirmed_at' => '1 day ago',
                                    ]
                                ]
                            ]
                        ]
                    ],
                ]
            );
    }

    // vendor/bin/phpunit --filter friend_request_can_be_ignored

    /** @test */
    public function friend_request_can_be_ignored()
    {
        $this->actingAs($user = User::factory()->create(), 'api');
        $anotherUser = User::factory()->create();

        $this->post('/api/friend-request', [
            'friend_id' => $anotherUser->id,
        ])->assertStatus(200);

        $response = $this->actingAs($anotherUser, 'api')
            ->delete('/api/friend-request-response/delete', [
                'user_id' => $user->id,
            ])->assertStatus(204);

        $friendRequest = Friend::first();
        $this->assertNull($friendRequest);
        $response->assertNoContent();
    }

    // vendor/bin/phpunit --filter only_the_recipient_can_ignore_a_friend_request

    /** @test */
    public function only_the_recipient_can_ignore_a_friend_request()
    {
        $this->withExceptionHandling();

        $this->actingAs($user = User::factory()->create(), 'api');
        $anotherUser = User::factory()->create();

        $this->post('/api/friend-request', [
            'friend_id' => $anotherUser->id,
        ])->assertStatus(200);

        $response = $this->actingAs(User::factory()->create(), 'api')
            ->delete('/api/friend-request-response/delete', [
                'user_id' => $user->id,
                'status' => 1,
            ])->assertStatus(404);

        $friendRequest = Friend::first();
        $this->assertNull($friendRequest->confirmed_at);
        $this->assertNull($friendRequest->status);
        $response->assertJson([
            'errors' => [
                'code' => 404,
                'title' => "Friend Request not found",
                'detail' => 'Unable to locate the friend request with the given information'
            ]
        ]);
    }

    // vendor/bin/phpunit --filter a_user_id_is_required_for_ignoring_a_friend_request_responses

    /** @test */
    public function a_user_id_is_required_for_ignoring_a_friend_request_responses()
    {
        $response = $this->actingAs($user = User::factory()->create(), 'api')
            ->delete('/api/friend-request-response/delete', [
                'user_id' => '',
            ])->assertStatus(422);

        $responseString = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('user_id', $responseString['errors']['meta']);
    }
}
