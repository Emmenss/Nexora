<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BoutiqueController;
// use App\Http\Controllers\RegisterController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


//upload image
// Route::post('/upload-image', [EmailController::class, 'uploadImage']);


Route::post('/send-sms', [NotificationController::class, 'sendSmsNotification']);

Route::post('/send-email', [NotificationController::class, 'sendEmailNotification']);


// registering
Route::post('/register', [RegisterController::class, 'register']);

Route::middleware('auth:sanctum')->get('/allboutique', [BoutiqueController::class, 'afficherBoutique']);


// authentification et deconnexion
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/user', [AuthController::class, 'user'])->middleware('auth:sanctum');


// creatin d'une boutique
Route::middleware('auth:sanctum')->post('/boutiques', [BoutiqueController::class, 'createshop']);
// 

Route::post('/products', [BoutiqueController::class, 'createproduct']);

// Route::post('/register', [RegisterController::class, 'register']);
// Route::post('/login', [RegisterController::class, 'login']);
// Route::middleware('auth:sanctum')->get('/user', [AuthController::class, 'user']);


//ajouter un produit dans un panier
Route::post('/panier/ajouter', [PanierController::class, 'ajouterAuPanier']);
Route::get('/panier', [PanierController::class, 'afficherPanier']);

// 


