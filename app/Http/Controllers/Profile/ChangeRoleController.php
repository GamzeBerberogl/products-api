<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangeRoleRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserResource;
use App\Http\Responses\ApiSuccessResponse;
use App\Http\Responses\ApiErrorResponse;

class ChangeRoleController extends Controller
{
    public function __invoke(ChangeRoleRequest $request)
    {
        $user = Auth::user();
        
        if(!$user->role->contains('role_id', $request->role))
            return new ApiErrorResponse(
                new \Exception(),
                'Bu rolü kullanmak için yetkiniz bulunmamaktadır.',
            );

        $user->role()->update(['is_active' => false]);
        $user->role()->where('role_id',$request->role)->update(['is_active' => true]);

        $response = [
            'user' => new UserResource($user)
        ];

        return new ApiSuccessResponse(
            $response,
            ['Aktif rolünüz başarıyla değiştirilmiştir.']
        );
    }
}
