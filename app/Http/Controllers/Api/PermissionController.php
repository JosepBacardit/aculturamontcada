<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionRequest;
use App\Http\Resources\PermissionResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $permissions = Permission::all();

        return PermissionResource::collection($permissions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PermissionRequest $request
     *
     * @return array
     */
    public function store(PermissionRequest $request): PermissionResource
    {
        $permission = Permission::create($request->all());

        return PermissionResource::make($permission);
    }

    /**
     * Display the specified resource.
     *
     * @param Permission $permission
     *
     * @return PermissionResource
     */
    public function show(Permission $permission): PermissionResource
    {
        return PermissionResource::make($permission);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PermissionRequest $request
     * @param Permission $permission
     *
     * @return array
     */
    public function update(PermissionRequest $request, Permission $permission): PermissionResource
    {
        $permission->update($request->all());

        return PermissionResource::make($permission);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Permission $permission
     *
     * @return array
     */
    public function destroy(Permission $permission): PermissionResource
    {
        $permission->delete();

        return PermissionResource::make($permission);
    }
}
