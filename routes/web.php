<?php

use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SiteController::class, 'index']);
Route::get('/cashout', [SiteController::class, 'cashout'])->name('view.cashout');
Route::get('/income', [SiteController::class, 'income'])->name('view.income');
Route::get('/report-page', [SiteController::class, 'reportPage'])->name('view.report');

Route::get('/datatable-cashout', [SiteController::class, 'datatableCashout']);
Route::get('/datatable-income', [SiteController::class, 'datatableIncome']);

Route::get('/daily-report/{date}', [SiteController::class, 'report']);
Route::get('/avarage-report/{date}', [SiteController::class, 'avarageReport']);
Route::get('/chart/{date}', [SiteController::class, 'chartReport']);
