<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{

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