<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthLogoutRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Auth controller
 *
 */
class AuthController extends Controller
{
    /**
     * Login user and get api token
     *
     * @OA\Post(
     *    path="/api/auth/login",
     *    summary="Authenticate user and get api token",
     *    tags={"Auth"},
     *    description="Authenticate user and get api token.",
     *    operationId="authLogin",
     *    @OA\RequestBody(
     *       required=true,
     *       @OA\JsonContent(
     *          required={"email", "password"},
     *          @OA\Property(property="email", type="string", format="string", example="example@example.com"),
     *          @OA\Property(property="password", type="password", format="string", example="12345678"),
     *       ),
     *    ),
     *    @OA\Response(
     *        response=200,
     *        description="successful operation",
     *        @OA\Schema(
     *            type="array"
     *        ),
     *    ),
     *    @OA\Response(
     *        response=401,
     *        description="Invalid credentials",
     *        @OA\Schema(
     *            type="array"
     *        ),
     *    )
     * )
     *
     * @param AuthLoginRequest $request
     *
     * @return JsonResponse
     */
    public function login(AuthLoginRequest $request): JsonResponse
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json([
                'token' => $token,
                'data' => UserResource::make($user)
            ], 200);
        } else {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    }

    /**
     * Logout and delete token
     *
     * @OA\Post(
     *    path="/api/auth/logout",
     *    summary="Logout user and delete api token",
     *    tags={"Auth"},
     *    description="Logout user and delete api token.",
     *    security={ {"sanctum": {} }},
     *    operationId="authLogout",
     *    @OA\Response(
     *        response=200,
     *        description="successful operation",
     *        @OA\Schema(
     *            type="array"
     *        ),
     *    )
     * )
     *
     * @param AuthLogoutRequest $request
     *
     * @return JsonResponse
     */
    public function logout(AuthLogoutRequest $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out'], 200);
    }
}
