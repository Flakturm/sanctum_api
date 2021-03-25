<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\Member\UserResource;
use App\Models\Role;
use App\Models\User;
use App\Notifications\AccountActivated;
use App\Notifications\SendActivationToken;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'email' => ['required', 'string', 'email', 'unique:users', Rule::unique('users')->where(function ($query) {
                return $query->where('active', true);
            })],
            'password' => 'required|confirmed|min:8|max:12'
        ]);

        if ($user = User::where('email', $request->email)->where('active', false)->first()) {
            $user->name = $request->name;
            $user->password = bcrypt($request->password);
            $user->activation_token = Str::random(60);
            $user->save();
            $user->notify(new SendActivationToken($user));
        } else {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'activation_token' => Str::random(60)
            ]);
            $user->notify(new SendActivationToken($user));
        }

        $user->assignRole(Role::ROLE_MEMBER);

        return response()->json([], Response::HTTP_CREATED);
    }

    public function activate($token)
    {
        $user = User::where('activation_token', $token)->first();

        if (!$user) {
            return redirect()->route('client.account.activated')->with('error', __('auth.action_denied'));
        }

        $user->active = true;
        $user->activation_token = '';
        $user->email_verified_at = now();
        $user->save();

        $user->notify(new AccountActivated($user));

        return redirect()->route('client.account.activated');
    }

    public function me(Request $request)
    {
        return new UserResource($request->user());
    }
}
