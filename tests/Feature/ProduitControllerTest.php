<?php

namespace Tests\Feature;

use App\Models\Produit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProduitControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Test the /produits endpoint returns all products.
     */
    public function test_get_all_produits_returns_all_products(): void
    {
        $response = $this->getJson('/api/produits');

        $response->assertStatus(200)
                ->assertJsonCount(3)
                ->assertJsonStructure([
                    '*' => [
                        'id',
                        'reference',
                        'libelle',
                        'est_du_jour',
                        'prix',
                        'quantite_en_stock',
                        'image_url'
                    ]
                ]);

        // Verify specific products are included
        $response->assertJsonFragment([
            'reference' => 'REF001',
            'libelle' => 'Vin Elrond',
            'est_du_jour' => false,
            'prix' => '34.90',
            'quantite_en_stock' => 12,
            'image_url' => 'vin_elrond.jpg'
        ]);

        $response->assertJsonFragment([
            'reference' => 'REF002',
            'libelle' => 'Hache de Gimli',
            'est_du_jour' => false,
            'prix' => '15.00',
            'quantite_en_stock' => 0,
            'image_url' => 'hache.jpg'
        ]);

        $response->assertJsonFragment([
            'reference' => 'REF003',
            'libelle' => 'Potion des Istari',
            'est_du_jour' => true,
            'prix' => '89.99',
            'quantite_en_stock' => 3,
            'image_url' => 'potion_des_istari.jpg'
        ]);
    }

    /**
     * Test the /produits-du-jour endpoint returns only products with est_du_jour = true.
     */
    public function test_get_produits_du_jour_returns_only_featured_products(): void
    {
        $response = $this->getJson('/api/produits-du-jour');

        $response->assertStatus(200)
                ->assertJsonCount(1)
                ->assertJsonStructure([
                    '*' => [
                        'id',
                        'reference',
                        'libelle',
                        'est_du_jour',
                        'prix',
                        'quantite_en_stock'
                    ]
                ]);

        // Verify only the featured product is returned
        $response->assertJsonFragment([
            'reference' => 'REF003',
            'libelle' => 'Potion des Istari',
            'est_du_jour' => true,
            'prix' => '89.99',
            'quantite_en_stock' => 3,
            'image_url' => 'potion_des_istari.jpg'
        ]);

        // Verify non-featured products are not included
        $response->assertJsonMissing([
            'reference' => 'REF001'
        ]);

        $response->assertJsonMissing([
            'reference' => 'REF002'
        ]);
    }
}
