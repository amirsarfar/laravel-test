<?php

use App\Http\Controllers\ProductController;
use App\Models\User;
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

Route::group(['prefix' => 'v1'], function() {

    // Protected Routes
    Route::group(['middleware' => 'auth:sanctum'], function() {
        Route::get('/user', function (Request $request) {
            return $request->user();
        });
    });

    // Public Routes
    Route::get('products', [ProductController::class, 'index']);
    Route::get('products/{product}', [ProductController::class, 'show']);
    Route::get('/login', function(Request $request) {
        $token = User::find(1)->createToken('ma-token');
        return ['token' => $token->plainTextToken];
    });
});
