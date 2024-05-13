<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserResource;
use App\Http\Responses\ApiSuccessResponse;
use App\Http\Requests\UpdateProfileRequest;

class ProfileController extends Controller
{
    /**
     * Return Auth user
     *
     * @param  Request  $request
     * @return mixed
     */
    public function show()
    {
        $user = Auth::user();

        $response = [
            'user' => new UserResource($user)
        ];

        return new ApiSuccessResponse(
            $response,
            []
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProfileRequest $request)
    {
        $user = Auth::user();

        $input = $request->all();

        $user->fill($input)->save();

        $response = [
            'user' => new UserResource($user)
        ];

        return new ApiSuccessResponse(
            $response,
            ['message' => 'Profiliniz başarıyla güncellendi.']
        );
    }
}
