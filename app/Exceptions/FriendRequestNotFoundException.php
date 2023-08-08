<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FriendRequestNotFoundException extends Exception
{
    /**
     * Render the exception as an HTTP response.
     */
    public function render(Request $request): JsonResponse
    {
        return response()->json([
            'errors' => [
                'code' => 404,
                'title' => "Friend Request not found",
                'detail' => 'Unable to locate the friend request with the given information'
            ]
        ], 404);
    }
}
