<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPassword;
use App\Http\Responses\ApiSuccessResponse;
use App\Http\Responses\ApiErrorResponse;
use App\Models\User;

class ResetPasswordController extends Controller
{
	public function sendPasswordResetLinkEmail(Request $request)
	{
		$request->validate([
			'email' => 'required|email|exists:users,email'
		],
		[],
		[
			'email' => __('user.email')
		]);

		$status = Password::broker()->sendResetLink(
			$request->only('email'),
			function ($user, $token) use ($request)
			{
				//Email
				$details = [
					'url' => env('FRONTEND_URL').'/reset-password?token='.$token.'&email='.urlencode($request->email),
				];

				Mail::to($request->email)->send(new ResetPassword($details));
			}
		);

		return new ApiSuccessResponse(
            [],
            ['message' => __($status)]
        );
	}

	public function resetPassword(Request $request)
	{
		$request->validate([
			'token' => 'required',
			'email' => 'required|email|exists:users',
			'password' => 'required|min:8|confirmed',
		],
		[],
		[
			'email' => __('user.email'),
			'password' => __('user.password'),
		]);

		$status = Password::reset(
			$request->only('email', 'password', 'password_confirmation', 'token'),
			function ($user, $password) {
				$user->forceFill([
					'password' => Hash::make($password)
				])->setRememberToken(Str::random(60));

				$user->save();

				event(new PasswordReset($user));
			}
		);

		if($status == Password::PASSWORD_RESET)
		{
			return new ApiSuccessResponse(
				[],
				['message' => __('passwords.reset')]
			);
		}
		else
		{
			return new ApiErrorResponse(
				new \Exception(),
				__('passwords.reset'),
				Response::HTTP_UNAUTHORIZED
			);
		}
	}

	public function checkToken(Request $request)
	{
		$request->validate([
			'token' => 'required',
			'email' => 'required|email|exists:users',
		],
		[],
		[
			'email' => __('user.email'),
		]);

		$user = User::whereEmail($request->email)->active()->first();

		if (! Password::broker()->tokenExists($user, $request->token)) {
			return new ApiErrorResponse(
				new \Exception(),
				trans(Password::INVALID_TOKEN),
				Response::HTTP_UNAUTHORIZED
			);
        }

		return new ApiSuccessResponse(
			[],
			['message' => __('passwords.token_valid')]
		);
	}
}