<?php

namespace App\Http\Controllers\Auth;

use App\Helper\ApiMessage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->all(['email', 'password']);

        Validator::make($credentials, [
            'email' => 'required|string',
            'password' => 'required|string'
        ])->validate();

        $token = auth('api')->attempt($credentials);

        if(!$token)
        {
            $message = new ApiMessage('Unauthorized');
            return response()->json($message->sendMessage(), 401);
        }

        return response()->json(['token' => $token], 200);
    }


    public function logout()
    {
        auth('api')->logout();

        return response()->json(['data' => 'see you later'], 200);
    }


    public function refreshToken()
    {
        $newToken = auth('api')->refresh();

        return response()->json(['token' => $newToken], 200);
    }
}
