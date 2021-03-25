<?php

namespace App\Http\Controllers\Dashboard;

use App\Filters\UserFilters;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\UserRequest;
use App\Http\Resources\Dashboard\UserResource;
use App\Http\Resources\Dashboard\UserResourceCollection;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Response;

class MemberController extends Controller
{
    public function index(UserFilters $filters)
    {
        $users = User::filter($filters)
            ->role(Role::ROLE_MEMBER)
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

        $user->assignRole(Role::ROLE_MEMBER);

        return response()->json([], Response::HTTP_CREATED);
    }

    public function show(User $member)
    {
        return response()->json(new UserResource($member), Response::HTTP_OK);
    }

    public function update(UserRequest $request, User $member)
    {
        $member->update($request->all());
        $member->password = bcrypt($request->password);
        $member->save();

        if ($request->has('member_vendor_toggle') && $request->member_vendor_toggle === true) {
            $member->syncRoles([Role::ROLE_VENDOR]);
        }

        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    public function restore($id)
    {
        $member = User::onlyTrashed()->find($id);
        $member->restore();
        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    public function destroy(User $member)
    {
        $member->delete();
        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
