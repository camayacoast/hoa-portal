<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email|string|exists:users,email',
            'password' => [
                'required',
            ],
        ]);

        if (!Auth::attempt($credentials)) {
            return response([
                'error' => 'The Provided credentials are not correct'
            ], 422);
        }
        $user = Auth::user();

        $token = $user->createToken('main')->plainTextToken;
//        list($userTokenId, $userTokenValue) = explode('|', $token);
//        $logoutExistingTokens = $user->tokens->filter(function ($value, $key) use ($userTokenId) {
//            return $value->id != $userTokenId;
//        })->pluck('id')->all();
//
//        if ($logoutExistingTokens) {
////            LogoutEvent::dispatch($logoutExistingTokens);
//
//            $user->tokens->each(function ($token) use ($logoutExistingTokens) {
//                if (in_array($token->id, $logoutExistingTokens)) {
//                    $token->delete();
//                }
//            });
//        }

        return response([
            'user' => $user,
            'token' => $token
        ]);
    }


    public function logout()
    {
      $user = Auth::user();

        //Revoke the token that was used to authenticate the current request....
      $user->tokens()->where('id',$user->id)->delete();
        return response([
            'success' => true
        ]);
    }
}
