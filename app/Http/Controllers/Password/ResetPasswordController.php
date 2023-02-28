<?php

namespace App\Http\Controllers\Password;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required|string',
            'password' => 'required|min:8|confirmed',
        ]);

        $response = Password::reset($request->only(
            'email',
            'token',
            'password',
            'password_confirmation'
        ), function ($user, $password) {
            $user->password = Hash::make($password);
            $user->save();
        });

        if ($response === Password::PASSWORD_RESET) {
            return response()->json(['message' => 'Contraseña restablecida'], 200);
        } else {
            return response()->json(['message' => 'Contraseña no restablecida'], 400);
        }
    }
}
