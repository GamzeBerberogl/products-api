<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $user = User::where('email', $this->email)->first();

        return [
            'email' => ['required', 'email', function ($attribute, $value, $fail) use ($user) {
                if(is_null($user)) {
                    return $fail(__('auth.no_account'));
                }

                if ($user->email_verified_at != null && $user->is_active != true) {
                    return $fail(__('auth.passive_account'));
                }
            }],
            'password' => ['required',function ($attribute, $value, $fail) use ($user) {
                if(!is_null($user) && $user->is_active == true) {
                    if (!Hash::check($value, $user->password)) {
                        return $fail(__('auth.password'));
                    }
                }
            }]
        ];
    }
}