<?php

namespace App\Http\Controllers\Dashboard;

use App\Filters\UserFilters;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
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
            ->permission(Permission::ACCESS_DASHBOARD)
            ->orderBy(request()->sortBy, str_boolean(request()->descending) ? 'desc' : 'asc')
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

        $user->givePermissionTo(Permission::ACCESS_DASHBOARD);

        return response()->json([], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
