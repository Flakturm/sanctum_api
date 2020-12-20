<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Response;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::get()->pluck('name');
        return response()->json($permissions, Response::HTTP_OK);
    }
}
