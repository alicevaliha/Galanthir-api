<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProduitController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ClientController;

Route::get('/produits-du-jour', [ProduitController::class, 'produitsDuJour']);
Route::get('/produits', [ProduitController::class, 'getAll']);
Route::post('/auth/login', [ClientController::class, 'authenticate']);

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


