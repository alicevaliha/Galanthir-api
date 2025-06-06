<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *     title="Gondor Chic API",
 *     version="1.0.0",
 *     description="A Laravel-based API application for Magic VenteStock - the e-commerce platform for Minas Tirith's magical products. Features inventory management, order processing, and delivery tracking for fairy dust, mithril shirts, and other enchanted items sold through Gondor's retail network.",
 * )
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST,
 *     description="API Server"
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
