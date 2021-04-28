<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RecipeListController;

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

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);

    //crud for list
    Route::get('/recipelists', [RecipeListController::class, 'index']);
    Route::get('/recipelists/{id}', [RecipeListController::class, 'show']);
    Route::post('/recipelists', [RecipeListController::class, 'store']);
    Route::put('/recipelists/{id}', [RecipeListController::class, 'update']);
    Route::delete('/recipelists/{id}', [RecipeListController::class, 'destroy']);

    //crud for saved recipes
});