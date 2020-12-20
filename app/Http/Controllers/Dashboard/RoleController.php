<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Http\Resources\Dashboard\RoleResource;
use App\Models\Role;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return response()->json($roles, Response::HTTP_OK);
    }

    public function store(RoleRequest $request)
    {
        $role = Role::create($request->only('name'));

        $permissions = $this->sanitiseArray($request->permissions);

        $role->syncPermissions($permissions);

        return response()->json([], Response::HTTP_CREATED);
    }

    public function show(Role $role)
    {
        $role = $role->load('permissions');

        return response()->json(new RoleResource($role), Response::HTTP_OK);
    }

    public function update(RoleRequest $request, Role $role)
    {
        $role->update($request->only('name'));

        $permissions = $this->sanitiseArray($request->permissions);

        $role->syncPermissions($permissions);

        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    private function sanitiseArray($array): Collection
    {
        return collect($array)->filter(function ($value) {
            return !empty($value);
        });
    }
}
