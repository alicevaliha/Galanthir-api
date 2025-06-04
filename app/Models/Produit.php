<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
    ];

    protected $casts = [
        'est_du_jour' => 'boolean',
    ];
}
