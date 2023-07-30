<?php

use App\Http\Controllers\SiteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::post('/cashout', [SiteController::class, 'createCashout']);
Route::put('/cashout/update/{id}', [SiteController::class, 'updateCashout']);
Route::delete('/cashout/delete/{id}', [SiteController::class, 'deleteCashout']);

Route::post('/income', [SiteController::class, 'createIncome']);
Route::put('/income/update/{id}', [SiteController::class, 'updateIncome']);
Route::delete('/income/delete/{id}', [SiteController::class, 'deleteIncome']);

Route::get('/chart-data/{date}', [SiteController::class, 'chartData']);
