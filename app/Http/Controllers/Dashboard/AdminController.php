<?php

namespace App\Http\Controllers\Dashboard;

use App\Filters\UserFilters;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\Dashboard\UserRoleResource;
use App\Http\Resources\Dashboard\UserResourceCollection;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Response;

class AdminController extends Controller
{
    public function index(UserFilters $filters)
    {
        $users = User::filter($filters)
            ->permission(Permission::BROWSE_DASHBOARD)
            ->orderBy(request()->sortBy, str_boolean(request()->descending) ? 'desc' : 'asc')
            ->where('id', '<>', request()->user()->id)
            ->paginate(request()->rowsPerPage);

        return response()->json(new UserResourceCollection($users), Response::HTTP_OK);
    }

    public function store(UserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
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

    public function destroy(User $admin)
    {
        $admin->delete();
        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
