<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\PasswordReset;
use App\Models\User;
use App\Notifications\PasswordResetSuccess;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ResetPasswordController extends Controller
{
    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|confirmed|min:8',
            'token' => 'required|string'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['errors' => [
                'email' => [__('passwords.user')]
            ]], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $passwordReset = PasswordReset::where('token', $request->token)->first();

        if (!$passwordReset) {
            return response()->json(['errors' => [
                'token' => [__('passwords.token')]
            ]], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if (Carbon::parse($passwordReset->updated_at)->addMinutes(720)->isPast()) {
            $passwordReset->delete();
            return response()->json(['errors' => [
                'token' => [__('passwords.token')]
            ]], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $passwordReset = PasswordReset::where([
            ['token', $request->token],
            ['email', $request->email]
        ])->first();

        if (!$passwordReset) {
            return response()->json(['errors' => [
                'password' => [__('passwords.failed')]
            ]], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user->password = bcrypt($request->password);
        $user->save();

        $passwordReset->delete();

        $user->notify(new PasswordResetSuccess());

        return response()->json([], Response::HTTP_OK);
    }
}
