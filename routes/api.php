<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CEOController;
use App\Http\Controllers\API\mpesaController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::apiResource('/ceo', CEOController::class)->middleware('auth:api');
Route::post('/accessToken', [mpesaController::class, 'generateAccessToken']);
Route::post('/stkPush', [mpesaController::class, 'STKPush']);


// $mpesasdk = new mpesaController();

// $accessToken = $mpesasdk->generateAccessToken();


// Route::post('/stkPush', [mpesaController::class, 'STKPush']);
