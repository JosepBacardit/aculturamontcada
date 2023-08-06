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
     * @OA\Get(
     *     path="/api/permissions",
     *     summary="Display a listing of the permissions",
     *     tags={"Permissions"},
     *     description="Display a listing of the permissions.",
     *     operationId="indexPermission",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\Schema(
     *             type="array"
     *         ),
     *     )
     * )
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
     * @OA\Post(
     *    path="/api/permissions",
     *    summary="Store a perimission in database",
     *    tags={"Permissions"},
     *    description="Store a permission in database.",
     *    operationId="storePermission",
     *    @OA\RequestBody(
     *       required=true,
     *       @OA\JsonContent(
     *          required={"name"},
     *          @OA\Property(property="name", type="string", format="string", example="Store role"),
     *          @OA\Property(property="guard_name", type="string", format="string", example="web"),
     *       ),
     *    ),
     *    @OA\Response(
     *        response=200,
     *        description="successful operation",
     *        @OA\Schema(
     *            type="array"
     *        ),
     *    )
     * )
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
     * @OA\Get(
     *    path="/api/permissions/{permissionId}",
     *    summary="Display a specific permission",
     *    tags={"Permissions"},
     *    description="Display a specific permission.",
     *    operationId="showPermission",
     *    @OA\Parameter(
     *       name="permissionId",
     *       in="path",
     *       description="Id of permission that needs to be fetched",
     *       required=true,
     *       @OA\Schema(
     *           type="integer",
     *           format="int64",
     *           minimum=1.0
     *       )
     *    ),
     *    @OA\Response(
     *        response=200,
     *        description="successful operation",
     *        @OA\Schema(
     *            type="array"
     *        ),
     *    )
     * )
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
     * @OA\Put(
     *    path="/api/permissions/{permissionId}",
     *    summary="Update a permission in database",
     *    tags={"Permissions"},
     *    description="Update a permission in database.",
     *    operationId="updatePermission",
     *    @OA\Parameter(
     *       name="permissionId",
     *       in="path",
     *       description="Id of permission that needs to be updated",
     *       required=true,
     *       @OA\Schema(
     *           type="integer",
     *           format="int64",
     *           minimum=1.0
     *       )
     *    ),
     *    @OA\RequestBody(
     *       required=true,
     *       @OA\JsonContent(
     *          required={"name"},
     *          @OA\Property(property="name", type="string", format="string", example="Admin"),
     *          @OA\Property(property="guard_name", type="string", format="string", example="web"),
     *       ),
     *    ),
     *    @OA\Response(
     *        response=200,
     *        description="successful operation",
     *        @OA\Schema(
     *            type="array"
     *        ),
     *    )
     * )
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
     * @OA\Delete(
     *    path="/api/permissions/{permissionId}",
     *    summary="Delete a permission in database",
     *    tags={"Permissions"},
     *    description="Delete a permission in database.",
     *    operationId="deletePermission",
     *    @OA\Parameter(
     *       name="permissionId",
     *       in="path",
     *       description="Id of permission that needs to be deleted",
     *       required=true,
     *       @OA\Schema(
     *           type="integer",
     *           format="int64",
     *           minimum=1.0
     *       )
     *    ),
     *    @OA\Response(
     *        response=200,
     *        description="successful operation",
     *        @OA\Schema(
     *            type="array"
     *        ),
     *    )
     * )
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
