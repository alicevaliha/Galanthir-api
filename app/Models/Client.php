<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Client extends Authenticatable implements JWTSubject
{
    use HasFactory;

    protected $table = 't_client';

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
