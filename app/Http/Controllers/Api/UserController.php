<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Tag(
 *     name="Users",
 *     description="API Endpoints for user authentication and management"
 * )
 */
class UserController extends Controller
{

    /**
     * @OA\Post(
     *     path="/api/auth/register",
     *     operationId="registerUser",
     *     tags={"Users"},
     *     summary="Register a new user",
     *     description="Creates a new user account with the provided information",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"pseudo", "nom", "prenom", "mot_de_passe"},
     *             @OA\Property(property="pseudo", type="string", description="Unique username", example="gandalf_le_gris"),
     *             @OA\Property(property="nom", type="string", description="Last name", example="Gandalf"),
     *             @OA\Property(property="prenom", type="string", description="First name", example="Mithrandir"),
     *             @OA\Property(property="mot_de_passe", type="string", description="Password (minimum 6 characters)", example="password123"),
     *             @OA\Property(property="image_url", type="string", description="Optional profile image URL", example="gandalf.jpg")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Utilisateur créé avec succès"),
     *             @OA\Property(property="user", ref="#/components/schemas/User")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="errors", type="object", description="Validation errors")
     *         )
     *     )
     * )
     */
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'pseudo' => 'required|string|unique:users,pseudo',
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'mot_de_passe' => 'required|string|min:6',
            'image_url' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = new User();
        $user->pseudo = $request->pseudo;
        $user->nom = $request->nom;
        $user->prenom = $request->prenom;
        $user->mot_de_passe = Hash::make($request->mot_de_passe);
        $user->image_url = $request->image_url;
        $user->save();

        return response()->json(['message' => 'Utilisateur créé avec succès', 'user' => $user], 201);
    }

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
    public function login(Request $request)
    {
        $request->validate([
            'pseudo' => 'required|string',
            'mot_de_passe' => 'required|string',
        ]);

        $user = User::where('pseudo', $request->pseudo)->first();

        //dd(get_class($user));
        //return response()->json($user,200);

        if (!$user || !Hash::check($request->mot_de_passe, $user->mot_de_passe)) {
            return response()->json(['error' => 'Identifiants invalides'], 401);
        }

        // dd([
        //     'class' => get_class($user),
        //     'jwt' => $user instanceof \Tymon\JWTAuth\Contracts\JWTSubject,
        //     'interfaces' => class_implements($user),
        //     'file' => (new \ReflectionClass($user))->getFileName(),
        // ]);

        $token = auth('api')->login($user);
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' => $user
        ]);
    }
}