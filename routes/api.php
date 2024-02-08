<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\IntervalToNowController;
use App\Http\Controllers\VehicleServiceRecordController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Di sini Anda dapat mendaftarkan rute API untuk aplikasi Anda. Rute-rute
| ini dimuat oleh RouteServiceProvider dalam grup yang ditetapkan oleh middleware "api".
| Nikmati pembangunan API Anda!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    /**
     * Mengembalikan pengguna yang diotentikasi.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    return $request->user();
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    // Rute yang sudah ada ditempatkan di sini...
    Route::post('/logout', [AuthController::class, 'logout']);

    // untuk mengisi interval to now
    Route::group(['prefix' => 'intervals'], function () {
        Route::get('/', [IntervalToNowController::class, 'index']);
        Route::post('/', [IntervalToNowController::class, 'store']);
        Route::get('/{intervalToNow}', [IntervalToNowController::class, 'show']);
        Route::put('/{intervalToNow}', [IntervalToNowController::class, 'update']);
        Route::delete('/{intervalToNow}', [IntervalToNowController::class, 'destroy']);
    });

    /**
     * Sumber daya RESTful untuk catatan layanan kendaraan.
     */
    Route::resource('vehicle-service-records', VehicleServiceRecordController::class);
});
