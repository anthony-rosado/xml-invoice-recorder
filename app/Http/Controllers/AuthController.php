<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Responses\BaseResponse;
use App\Http\Responses\ErrorResponse;
use App\Http\Responses\SuccessResponse;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request): BaseResponse
    {
        if (!Auth::attempt($request->only(['email', 'password']))) {
            return new ErrorResponse(__('auth.failed'));
        }

        /** @var User $user */
        $user = Auth::user();
        $accessToken = $user->createToken('login')->accessToken;

        return new SuccessResponse(
            __('auth.succeeded'),
            [
                'access_token' => $accessToken
            ]
        );
    }
}
