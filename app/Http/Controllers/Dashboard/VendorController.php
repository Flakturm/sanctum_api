<?php

namespace App\Http\Controllers\Dashboard;

use App\Filters\UserFilters;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\Dashboard\UserResourceCollection;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Response;

class VendorController extends Controller
{
    public function index(UserFilters $filters)
    {
        $users = User::filter($filters)
            ->role(Role::ROLE_VENDOR)
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

        $user->assignRole(Role::ROLE_VENDOR);

        return response()->json([], Response::HTTP_CREATED);
    }

    public function show(User $vendor)
    {
        return response()->json($vendor, Response::HTTP_OK);
    }

    public function update(UserRequest $request, User $vendor)
    {
        $vendor->update($request->all());
        $vendor->password = bcrypt($request->password);
        $vendor->save();

        if ($request->has('member_vendor_toggle') && $request->member_vendor_toggle === true) {
            $vendor->syncRoles([Role::ROLE_MEMBER]);
        }

        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    public function destroy(User $vendor)
    {
        $vendor->delete();
        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
