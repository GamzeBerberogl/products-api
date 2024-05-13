<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserResource;
use App\Http\Responses\ApiSuccessResponse;

class ChangePasswordController extends Controller
{
    public function __invoke(ChangePasswordRequest $request)
    {
        $user = Auth::user();

        $input = $request->only('password');

        $user->fill($input)->save();

        $response = [
            'user' => new UserResource($user)
        ];

        return new ApiSuccessResponse(
            $response,
            ['message' => 'Şifreniz başarıyla güncellenmiştir.']
        );
    }
}
