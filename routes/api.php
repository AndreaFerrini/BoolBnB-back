<?php

use App\Http\Controllers\Api\ApartmentFrontController as ApartmentFrontController;
use App\Http\Controllers\Api\FrontendUrlController as FrontendUrlController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/front_end', [FrontendUrlController::class, 'save_data']);

Route::get('/apartments', [ApartmentFrontController::class, 'index']);
Route::get('/apartment/{apartment_id}', [ApartmentFrontController::class, 'show']);
Route::get('/services', [ApartmentFrontController::class, 'get_services']);