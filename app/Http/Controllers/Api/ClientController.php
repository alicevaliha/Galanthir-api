<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

/**
 * @OA\Tag(
 *     name="Users",
 *     description="API Endpoints for user authentication and management"
 * )
 */
class ClientController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/auth/login",
     *     operationId="loginUser",
     *     tags={"Users"},
     *     summary="User login",
     *     description="Authenticate user and return JWT access token",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"pseudo", "mot_de_passe"},
     *             @OA\Property(property="pseudo", type="string", description="Username", example="gandalf_le_gris"),
     *             @OA\Property(property="mot_de_passe", type="string", description="Password", example="password123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login successful",
     *         @OA\JsonContent(
     *             @OA\Property(property="access_token", type="string", description="JWT access token"),
     *             @OA\Property(property="token_type", type="string", example="bearer"),
     *             @OA\Property(property="expires_in", type="integer", description="Token expiration time in seconds"),
     *             @OA\Property(property="user", ref="#/components/schemas/User")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Invalid credentials",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Identifiants invalides")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function authenticate(Request $request)
    {
        $request->validate([
            'pseudo' => 'required|string',
            'mot_de_passe' => 'required|string',
        ]);

        
        $user = Client::where('pseudo', $request->pseudo)->first();
        Log::info($user);

        if (!$user || !Hash::check($request->mot_de_passe, $user->mot_de_passe, [
            'rounds' => 12,
        ])) {
            return response()->json(['error' => 'Identifiants invalides'], 401);
        }

        $token = auth('api')->login($user);
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' => $user
        ]);
    }
}
