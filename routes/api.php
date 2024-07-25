<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\StoreImageController;


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


// Authentication register endpoint
Route::post('/v1/auth/register', [AuthController::class, 'userRegister']);

// Authentication login endpoint
Route::post('/v1/auth/login', [AuthController::class, 'userLogin']);

// Endpoints can be accessed only if user is authenticated
Route::group(['middleware' => ['auth:sanctum']], function(){

    // Store image endpoing
    Route::post('/v1/store-image', [StoreImageController::class, 'storeImage']);

});