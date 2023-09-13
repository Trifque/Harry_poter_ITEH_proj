<?php

use App\Http\Controllers\AwardController;
use App\Http\Controllers\Awarded_toController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\InteractionController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*GET funkcije za vracanje podataka iz baze */
Route::get('/getAllAdmins', [UserController::class, 'getAllAdmins']);
Route::get('/getAllRegularUsers', [UserController::class, 'getAllRegularUsers']);
Route::get('/getUserById/{user_id}', [UserController::class, 'getUserById']);

Route::get('/getAllCategories', [CategoriesController::class, 'getAllCategories']);

Route::get('/getAllAwards', [AwardController::class, 'getAllAwards']);

Route::get('/getPostsMadeByUser/{user_id}', [PostController::class, 'getPostsMadeByUser']);
Route::get('/getPostsLikedByUser/{user_id}', [PostController::class, 'getPostsLikedByUser']);
Route::get('/getPostsSavedByUser/{user_id}', [PostController::class, 'getPostsSavedByUser']);
Route::get('/getPostsCommentedByUser/{user_id}', [PostController::class, 'getPostsCommentedByUser']);
Route::get('/getNewPosts/{user_id}', [PostController::class, 'getNewPosts']);
Route::get('/getPostsByCategory/{category_name}/{user_id}', [PostController::class, 'getPostsByCategory']);