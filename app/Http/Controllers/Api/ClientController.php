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

class ClientController extends Controller
{
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
