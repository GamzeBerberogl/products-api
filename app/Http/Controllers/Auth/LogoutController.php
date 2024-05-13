<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Responses\ApiSuccessResponse;

class LogoutController extends Controller
{
    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();

        return new ApiSuccessResponse(
            [],
            ['message' => 'Başarıyla çıkış yaptınız.']
        );
    }
}