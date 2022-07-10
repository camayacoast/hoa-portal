<?php

namespace App\Http\Controllers\Member\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    public function changePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
        ]);

        $user = Auth::user();

        $user->password = Hash::make($request->password);
        $user->hoa_member_registered = 1;
        $request = $user->save();

        return $request;
    }
}
