<?php

use App\Http\Controllers\Api\ProductsController;
use App\Http\Controllers\Api\UserController;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


// make authentication user api
Route::namespace('userAuthentication')->group(function () {
    Route::post('/register', [UserController::class, 'register']);
    Route::post('/login', [UserController::class, 'login']);
});

// make api for products
Route::namespace('products-api')->middleware('auth:api')->group(function () {
    Route::get('/all-products', [ProductsController::class, 'index']);
    Route::delete('/delete-product/{id}', [ProductsController::class, 'destroy']);
    Route::get('/get-product/{id}', [ProductsController::class, 'show']);
    Route::post('/insert-product', [ProductsController::class, 'store']);
    Route::patch('/update-data/{id}', [ProductsController::class, 'update']);
});
