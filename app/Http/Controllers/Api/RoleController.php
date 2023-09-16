<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Http\Resources\RoleResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $roles = Role::all();

        return RoleResource::collection($roles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RoleRequest $request
     *
     * @return array
     */
    public function store(RoleRequest $request): RoleResource
    {
        $role = Role::create($request->all());

        return RoleResource::make($role);
    }

    /**
     * Display the specified resource.
     *
     * @param Role $role
     *
     * @return RoleResource
     */
    public function show(Role $role): RoleResource
    {
        return RoleResource::make($role);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param RoleRequest $request
     * @param Role $role
     *
     * @return array
     */
    public function update(RoleRequest $request, Role $role): RoleResource
    {
        $role->update($request->all());

        return RoleResource::make($role);
    }

    /**
     *
     * @param Role $role
     *
     * @return array
     */
    public function destroy(Role $role): RoleResource
    {
        $role->delete();

        return RoleResource::make($role);
    }
}
