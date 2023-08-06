<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Carbon;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/api/users",
     *     summary="Display a listing of the users",
     *     tags={"Users"},
     *     description="Display a listing of the users.",
     *     operationId="indexUser",
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
        $users = User::all();

        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     *
     * @OA\Post(
     *    path="/api/users",
     *    summary="Store a user in database",
     *    tags={"Users"},
     *    description="Store a user in database.",
     *    operationId="storeUser",
     *    @OA\RequestBody(
     *       required=true,
     *       @OA\JsonContent(
     *          required={"name", "email", "password", "confirm_password"},
     *          @OA\Property(property="name", type="string", format="string", example="Josep"),
     *          @OA\Property(property="email", type="string", format="string", example="example@example.com"),
     *          @OA\Property(property="password", type="password", format="string", example="12345678"),
     *          @OA\Property(property="password_confirmation", type="password", format="string", example="12345678"),
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
     * @OA\Get(
     *    path="/api/user/{userId}",
     *    summary="Display a specific user",
     *    tags={"Users"},
     *    description="Display a specific user.",
     *    operationId="showUser",
     *    @OA\Parameter(
     *       name="userId",
     *       in="path",
     *       description="Id of user that needs to be fetched",
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
     * @OA\Put(
     *    path="/api/users/{userId}",
     *    summary="Update a user in database",
     *    tags={"Users"},
     *    description="Update a user in database.",
     *    operationId="updateUser",
     *    @OA\Parameter(
     *       name="userId",
     *       in="path",
     *       description="Id of user that needs to be updated",
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
     *          required={"name", "email"},
     *          @OA\Property(property="name", type="string", format="string", example="Josep"),
     *          @OA\Property(property="email", type="string", format="string", example="example@example.com"),
     *          @OA\Property(property="password", type="password", format="string", example="12345678"),
     *          @OA\Property(property="password_confirmation", type="password", format="string", example="12345678"),
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
     * @OA\Delete(
     *    path="/api/users/{userId}",
     *    summary="Delete a user in database",
     *    tags={"Users"},
     *    description="Delete a user in database.",
     *    operationId="deleteUser",
     *    @OA\Parameter(
     *       name="userId",
     *       in="path",
     *       description="Id of user that needs to be deleted",
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
     * @param User $user
     *
     * @return UserResource
     */
    public function destroy(User $user): UserResource
    {
        $user->delete();

        return UserResource::make($user);
    }
}
