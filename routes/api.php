<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\InvoiceItems\GetTotalAccumulatedAmountPerItemController;
use App\Http\Controllers\Invoices\DeleteInvoiceController;
use App\Http\Controllers\Invoices\GetInvoiceListController;
use App\Http\Controllers\Invoices\UploadInvoiceController;
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

Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
});

Route::middleware('auth:api')->group(function () {
    Route::prefix('invoices')->group(function () {
        Route::post('/upload', UploadInvoiceController::class);
        Route::get('/', GetInvoiceListController::class);
        Route::delete('/{invoice}', DeleteInvoiceController::class);
    });

    Route::prefix('invoice-items')->group(function () {
        Route::get('/total-accumulated-amount-per-item', GetTotalAccumulatedAmountPerItemController::class);
    });
});
