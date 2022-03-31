<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(UserRequest $request)
    {
        $user = User::where('email', $request->email)->first();
    
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'credentials' => ['The provided credentials are incorrect.'],
            ]);
        }
    
        return [
            "plain_text_token" => $user->createToken($request->device_name)->plainTextToken
        ];
    }
}
