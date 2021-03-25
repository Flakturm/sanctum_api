<?php

namespace App\Http\Controllers\Dashboard;

use App\Filters\UserFilters;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\UserRequest;
use App\Http\Resources\Dashboard\UserRoleResource;
use App\Http\Resources\Dashboard\UserResourceCollection;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AdminController extends Controller
{
    public function index(UserFilters $filters)
    {
        $users = User::filter($filters)
            ->permission(Permission::BROWSE_DASHBOARD)
            ->where('id', '<>', auth()->id())
            ->paginate(request()->rowsPerPage);

        return response()->json(new UserResourceCollection($users), Response::HTTP_OK);
    }

    public function store(UserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'active' => $request->active
        ]);

        $user->syncRoles($request->roles);

        return response()->json([], Response::HTTP_CREATED);
    }

    public function show(User $admin)
    {
        return response()->json(new UserRoleResource($admin), Response::HTTP_OK);
    }

    public function update(UserRequest $request, User $admin)
    {
        $admin->update($request->all());
        $admin->password = bcrypt($request->password);
        $admin->save();

        $admin->syncRoles($request->roles);

        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|max:20'
        ]);

        $user = $request->user();
        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    public function restore($id)
    {
        $admin = User::onlyTrashed()->find($id);
        $admin->restore();
        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    public function destroy(User $admin)
    {
        $admin->delete();
        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
