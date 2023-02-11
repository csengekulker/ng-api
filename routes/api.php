<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ServiceController;
use App\Models\Product;
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

// Route::group(['middleware' => ['auth:sanctum']], function () {
//     Route::apiResource('products', ProductController::class)
//     ->except('index');
// });

Route::get('/products', [ProductController::class, 'index']);
Route::post('/products', [ProductController::class, 'store']);

Route::get('/clients', [ClientController::class, 'all_clients']);
Route::get('clients/{id}', [ClientController::class, 'get_client_by_id']);
Route::post('/clients', [ClientController::class, 'add_new_client']);
Route::put('/clients/{id}', [ClientController::class, 'modify_client']);
Route::delete('clients/{id}', [ClientController::class, 'remove_client']);

Route::get('/services', [ServiceController::class, 'all_services']);
Route::get('services/{id}', [ServiceController::class, 'get_service_by_id']);
Route::post('services', [ServiceController::class, 'add_new_service']);
Route::put('/services/{id}', [ServiceController::class, 'modify_service']);
Route::delete('services/{id}', [ServiceController::class, 'remove_service']);

Route::get('/bookings', [BookingController::class, 'all_bookings']);
Route::get('bookings/{id}', [BookingController::class, 'get_booking_by_id']);
Route::post('bookings', [BookingController::class, 'add_new_booking']);
Route::post('/bookings/{id}', [BookingController::class, 'approve_booking']);
Route::put('bookings/{id}', [BookingController::class, 'modify_booking']);
Route::delete('bookings/{id}', [BookingController::class, 'remove_booking']);

Route::post('/signup', [AuthController::class, 'register']);
Route::post('/signin', [AuthController::class, 'login']);
