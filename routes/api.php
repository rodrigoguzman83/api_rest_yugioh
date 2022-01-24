<?php

use App\Http\Controllers\V1\CardsController;
use App\Http\Controllers\V1\AuthController;
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

Route::prefix('v1')->group(function () {
    Route::post('login', [AuthController::class, 'authenticate']);
    Route::post('register', [AuthController::class, 'register']);
    Route::get('cards', [CardsController::class, 'index']);
    Route::get('cards/{id}', [CardsController::class, 'show']);
    Route::group(['middleware' => ['jwt.verify']], function () {
        //Todo lo que este dentro de este grupo requiere verificación de usuario.
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('get-user', [AuthController::class, 'getUser']);
        Route::post('cards', [CardsController::class, 'store']);
        Route::put('cards/{id}', [CardsController::class, 'update']);
        Route::delete('cards/{id}', [CardsController::class, 'destroy']);
    });
});
