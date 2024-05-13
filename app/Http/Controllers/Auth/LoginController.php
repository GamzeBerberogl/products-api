<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Http\Responses\ApiSuccessResponse;

class LoginController extends Controller
{
        /** Authenticate an user and dispatch token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request) {

        $user = User::where('email', $request->email)->first();

        $response = [
            'token' => $user->createToken('api-token', ['*'])->plainTextToken,
            'user' => new UserResource($user)
        ];

        return new ApiSuccessResponse(
            $response,
            ['message' => 'Başarıyla giriş yaptınız.']
        );
    }
}