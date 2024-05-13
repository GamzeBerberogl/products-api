<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Resources\UserResource;
use App\Http\Responses\ApiSuccessResponse;
use App\Models\User;

class ChangePasswordController extends Controller
{
    public function __invoke(ChangePasswordRequest $request, User $user)
    {
        $user->password = $request->new_password;
        $user->save();

        $response = [
            'user' => new UserResource($user)
        ];

        return new ApiSuccessResponse(
            $response,
            ['message' => 'Kullanıcının şifresi başarıyla değiştirilmiş.']
        );
    }
}
