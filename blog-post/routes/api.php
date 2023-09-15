<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Awarded_toController;
use App\Http\Controllers\InteractionController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {return $request->user();});

Route::post('/createPost', [PostController::class, 'createPost']);
Route::put('/editPost', [PostController::class, 'editPost']);
Route::delete('/deletePost', [PostController::class, 'deletePost']);

Route::post('/createCategory', [CategoriesController::class, 'createCategory']);
Route::delete('/deleteCategory', [CategoriesController::class, 'deleteCategory']);

Route::post('/loginUser', [UserController::class, 'loginUser']);
Route::post('/createUser', [UserController::class, 'createUser']);

Route::post('/createComment', [CommentController::class, 'createComment']);

Route::post('/giveAward', [Awarded_toController::class, 'giveAward']);

Route::post('/makeInteraction', [InteractionController::class, 'makeInteraction']);