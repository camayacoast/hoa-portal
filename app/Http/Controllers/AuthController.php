<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    // public function register(Request $request)
    // {
    //     $data = $request->validate([
    //         'lastName' => 'required|string',
    //         'firstName' => 'required|string',
    //         'middleName' => 'required|string',
    //         'email' => 'required|string|email|unique:users,email',
    //         'notification' => 'required',
    //     ]);
    //     $notif = array_chunk($data['notification'], ceil(count($data['notification']) / 2));
    //     $ebill = implode(",", $notif[0]);
    //     $sms = implode(",", $notif[1]);
    //     $user = User::create([
    //         'name' => $data['lastName'] . ' ' . $data['firstName'] . ' ' . $data['lastName'],
    //         'email' => $data['email'],
    //         'sms' =>  $ebill,
    //         'ebill' => $sms,
    //         'password' => bcrypt('Camaya123')
    //     ]);
    //     $token = $user->createToken('camayacoast')->plainTextToken;
    //     return response([
    //         'user' => $user,
    //         'token' => $token
    //     ]);
    // }

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
        return response([
            'user' => $user,
            'token' => $token
        ]);
    }


    public function logout()
    {
        $user = Auth::user();
        //Revoke the token that was used to authenticate the current request....
        $user->currentAccessToken()->delete();
        return response([
            'success' => true
        ]);
    }
}
