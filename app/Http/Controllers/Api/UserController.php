<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function index(Request $request)
    {
        return $request->user();
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'password' => 'nullable|string|confirmed|min:8|max:12'
        ]);

        $request->user()->update([
            'name' => $request->name,
            'password' => bcrypt($request->password)
        ]);

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
