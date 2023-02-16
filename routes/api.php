<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
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

//Route::resource('category', CategoryController::class);
//Public routes
Route::post('/register', [ AuthController::class, 'register' ]);
Route::post('/login', [ AuthController::class, 'login' ]);

Route::get('/category', [ CategoryController::class, 'index' ]);
Route::get('/category/{id}', [ CategoryController::class, 'show' ]);



//Protected routes
Route::group(['middleware' => ['auth:sanctum']], function(){
	Route::post('/logout', [ AuthController::class, 'logout' ]);

	Route::post('/category', [ CategoryController::class, 'store' ]);
	Route::put('/category/{id}', [ CategoryController::class, 'update' ]);
	Route::delete('/category/{id}', [ CategoryController::class, 'destroy' ]);

	Route::get('/category/search/{name}', [ CategoryController::class, 'search' ]);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
