<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Models\UserRole;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Http\Responses\ApiSuccessResponse;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('role:ROLE_ADMIN', [
    //         'only' => [
    //             'index'
    //         ]
    //     ]);
    // }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all availability records
        $users = User::paginate();

        // pass all eloquent objects to user collection
        return new UserCollection($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $input = $request->all();

        if($request->exists('is_active') == false)
        {
            $input['is_active'] = '0';
        }

        $user = new User;
        $user->fill($input)->save();

        // Kullanıcı güncelleyince aktif rolü değişiyor, buranın gözden geçirilmesi lazım.
        foreach($input['roles'] as $k => $role)
        {
            $roles[] = new UserRole(['role_id' => $role, 'is_active' => $k == 0 ? true : false]);
        }

        $user->role()->saveMany($roles);

        return new ApiSuccessResponse(
            new UserResource($user),
            ['message' => 'Kullanıcı ekleme işlemi başarıyla tamamlandı.']
        );
    }
    
    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        // pass all eloquent objects to user collection
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $input = $request->all();
        if($request->exists('is_active') == false)
        {
            $input['is_active'] = '0';
        }

        $user->fill($input)->save();

        // Kullanıcı güncelleyince aktif rolü değişiyor, buranın gözden geçirilmesi lazım.
        foreach($input['roles'] as $k => $role)
        {
            $roles[] = new UserRole(['role_id' => $role, 'is_active' => $k == 0 ? true : false]);
        }

        $user->role()->delete();
        $user->role()->saveMany($roles);

        return new ApiSuccessResponse(
            new UserResource($user),
            ['message' => 'Kullanıcı güncelleme işlemi başarıyla tamamlandı.']
        );
    }
}
