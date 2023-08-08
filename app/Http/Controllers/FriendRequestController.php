<?php

namespace App\Http\Controllers;

use App\Exceptions\UserNotFoundException;
use App\Exceptions\ValidationErrorException;
use App\Http\Resources\Friend as FriendResource;
use App\Models\Friend;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class FriendRequestController extends Controller
{
    /**
     * @throws UserNotFoundException
     * @throws ValidationErrorException
     */
    public function store()
    {
//        try {
        $data = request()->validate([
            'friend_id' => 'required',
        ]);
//        } catch (ValidationException $e) {
//            throw new ValidationErrorException(json_encode($e->errors()));
//        }

        try {
            User::findOrFail($data['friend_id'])
                ->friends()->attach(auth()->user());
        } catch (ModelNotFoundException $e) {
            throw new UserNotFoundException();
        }

        return new FriendResource(
            Friend::where('user_id', auth()->user()->id)
                ->where('friend_id', $data['friend_id'])
                ->first()
        );

//        Friend::create($data);
    }
}
