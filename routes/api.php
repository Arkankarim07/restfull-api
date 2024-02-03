<?php

use App\Http\Controllers\Api\V1\CostumerController;
use App\Http\Controllers\Api\V1\InvoiceController;
use App\Models\Costumer;
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

// Grup rute dengan konfigurasi tertentu untuk versi API 'v1'
Route::group([
    'prefix' => 'v1',  // Menambahkan awalan 'v1' pada URI rute
    'namespace' => 'App\Http\Controllers\Api\V1', // Menyertakan namespace untuk controller di dalam direktori 'Api/V1'
    'middleware' => 'auth:sanctum'], function () {
   Route::apiResource('costumers', CostumerController::class);
   Route::apiResource('invoices', InvoiceController::class); 

   Route::post('invoices/bulk', [InvoiceController::class, 'bulkStore']);
});