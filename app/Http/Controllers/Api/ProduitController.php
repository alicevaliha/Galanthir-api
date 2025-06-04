<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Produit;
use Illuminate\Http\JsonResponse;

class ProduitController extends Controller
{
    public function produitsDuJour(): JsonResponse
    {
        $produits = Produit::where('est_du_jour', true)->get();
        return response()->json($produits);
    }
    
      public function getAll(): JsonResponse
    {
        $produits = Produit::all();
        return response()->json($produits);
    }
    
}
