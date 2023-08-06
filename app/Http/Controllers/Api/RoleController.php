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
     * @OA\Get(
     *     path="/api/roles",
     *     summary="Display a listing of the roles",
     *     tags={"Roles"},
     *     description="Display a listing of the roles.",
     *     operationId="indexRole",
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
        $roles = Role::all();

        return RoleResource::collection($roles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *    path="/api/roles",
     *    summary="Store a role in database",
     *    tags={"Roles"},
     *    description="Store a role in database.",
     *    operationId="storeRole",
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
     * @OA\Get(
     *    path="/api/role/{roleId}",
     *    summary="Display a specific role",
     *    tags={"Roles"},
     *    description="Display a specific role.",
     *    operationId="showRole",
     *    @OA\Parameter(
     *       name="roleId",
     *       in="path",
     *       description="Id of role that needs to be fetched",
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
     * @OA\Put(
     *    path="/api/roles/{roleId}",
     *    summary="Update a role in database",
     *    tags={"Roles"},
     *    description="Update a role in database.",
     *    operationId="updateRole",
     *    @OA\Parameter(
     *       name="roleId",
     *       in="path",
     *       description="Id of role that needs to be updated",
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
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *    path="/api/roles/{roleId}",
     *    summary="Delete a role in database",
     *    tags={"Roles"},
     *    description="Delete a role in database.",
     *    operationId="deleteRole",
     *    @OA\Parameter(
     *       name="roleId",
     *       in="path",
     *       description="Id of role that needs to be deleted",
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
