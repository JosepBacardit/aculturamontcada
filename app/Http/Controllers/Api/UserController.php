<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Carbon;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $users = User::all();

        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserStoreRequest $request
     *
     * @return UserResource
     */
    public function store(UserStoreRequest $request): UserResource
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt($request->password),
        ]);

        return UserResource::make($user);
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     *
     * @return UserResource
     */
    public function show(User $user): UserResource
    {
        return UserResource::make($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserUpdateRequest $request
     * @param User $user
     *
     * @return UserResource
     */
    public function update(UserUpdateRequest $request, User $user): UserResource
    {
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => ($request->password) ? bcrypt($request->password) : $user->password,
        ]);

        return UserResource::make($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     *
     * @return UserResource
     */
    public function destroy(User $user): UserResource
    {
        $user->delete();

        return UserResource::make($user);
    }

    /**
     * Assign role to user
     *
     * @param User $user
     * @param Role $role
     *
     * @return UserResource
     */
    public function assignRole(User $user, Role $role): UserResource
    {
        try{
            $user->assignRole($role);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }

        return UserResource::make($user);
    }
}
