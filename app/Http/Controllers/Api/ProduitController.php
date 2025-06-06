<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Produit;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Tag(
 *     name="Produits",
 *     description="API Endpoints for managing magical products"
 * )
 */
class ProduitController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/produits-du-jour",
     *     operationId="getProduitsDuJour",
     *     tags={"Produits"},
     *     summary="Get today's featured magical products",
     *     description="Returns a list of magical products that are featured for today",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Produit")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     * )
     */
    public function produitsDuJour(): JsonResponse
    {
        $produits = Produit::where('est_du_jour', true)->get();
        return response()->json($produits);
    }

    /**
     * @OA\Get(
     *     path="/api/produits",
     *     operationId="getAllProduits",
     *     tags={"Produits"},
     *     summary="Get all magical products",
     *     description="Returns a list of all magical products in the inventory",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Produit")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     * )
     */
    public function getAll(): JsonResponse
    {
        $produits = Produit::all();
        return response()->json($produits);
    }

}
