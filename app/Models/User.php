<?php


namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * @OA\Schema(
 *     schema="User",
 *     type="object",
 *     title="User",
 *     description="User model for authentication and profile management",
 *     required={"id", "pseudo", "nom", "prenom"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         description="Unique identifier of the user"
 *     ),
 *     @OA\Property(
 *         property="pseudo",
 *         type="string",
 *         description="Unique username",
 *         example="gandalf_le_gris"
 *     ),
 *     @OA\Property(
 *         property="nom",
 *         type="string",
 *         description="User's last name",
 *         example="Gandalf"
 *     ),
 *     @OA\Property(
 *         property="prenom",
 *         type="string",
 *         description="User's first name",
 *         example="Mithrandir"
 *     ),
 *     @OA\Property(
 *         property="image_url",
 *         type="string",
 *         nullable=true,
 *         description="URL of the user's profile image",
 *         example="gandalf.jpg"
 *     )
 * )
 */
class User extends Authenticatable implements JWTSubject
{
    protected $fillable = [
        'pseudo', 'nom', 'prenom', 'mot_de_passe', 'image_url'
    ];

    protected $hidden = [
        'mot_de_passe',
    ];

    // JWT methods
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    // Pour que Laravel utilise le bon champ pour le mot de passe
    public function getAuthPassword()
    {
        return $this->mot_de_passe;
    }
}