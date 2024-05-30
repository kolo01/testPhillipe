<?php
use App\Http\Controllers\PaiementController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


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


    Route::post('/v1/oauth/login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);

    Route::post('/v1/transaction', [PaiementController::class, 'initiateTransaction']);


    Route::group(['middleware' => ['jwt.verify']], function() {
        Route::post('/v1/valided-transaction', [PaiementController::class, 'validedTransaction']);
        Route::post('/v1/check-status', [PaiementController::class, 'checkStatus']);
        Route::post('/v1/paiement', [PaiementController::class, 'openView']);
        Route::post('/V1/transfert-money',[MarchandController::class, 'ApiTransfertMoney']);
    });





