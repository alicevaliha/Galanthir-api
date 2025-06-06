<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Produit",
 *     type="object",
 *     title="Produit",
 *     description="Magical product model",
 *     required={"id", "reference", "libelle", "prix", "quantite_en_stock"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         description="Unique identifier of the product"
 *     ),
 *     @OA\Property(
 *         property="reference",
 *         type="string",
 *         description="Product reference code",
 *         example="REF001"
 *     ),
 *     @OA\Property(
 *         property="libelle",
 *         type="string",
 *         description="Product name/label",
 *         example="Vin Elrond"
 *     ),
 *     @OA\Property(
 *         property="est_du_jour",
 *         type="boolean",
 *         description="Whether this product is featured today",
 *         example=false
 *     ),
 *     @OA\Property(
 *         property="prix",
 *         type="string",
 *         description="Product price in GondAriary",
 *         example="34.90"
 *     ),
 *     @OA\Property(
 *         property="quantite_en_stock",
 *         type="integer",
 *         description="Available quantity in stock",
 *         example=12
 *     ),
 *     @OA\Property(
 *         property="image_url",
 *         type="string",
 *         description="URL of the product image",
 *         example="vin_elrond.jpg"
 * )
 */
class Produit extends Model
{
    protected $table = 't_produit';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'reference',
        'libelle',
        'est_du_jour',
        'prix',
        'quantite_en_stock',
        'image_url'
    ];

    protected $casts = [
        'est_du_jour' => 'boolean',
    ];
}
