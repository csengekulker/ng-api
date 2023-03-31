<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\MailerController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TypeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/clients', [ClientController::class, 'all_clients']);
Route::get('/clients/{id}', [ClientController::class, 'get_client_by_id']);
Route::post('/clients', [ClientController::class, 'new_client']);
Route::put('/clients/{id}', [ClientController::class, 'modify_client']);
Route::delete('/clients/{id}', [ClientController::class, 'remove_client']);

Route::get('/services', [ServiceController::class, 'all_services']);
Route::get('/services/{id}', [ServiceController::class, 'get_service_by_id']);
Route::post('/services', [ServiceController::class, 'new_service']);
Route::put('/services/{id}', [ServiceController::class, 'modify_service']);
Route::delete('/services/{id}', [ServiceController::class, 'remove_service']);

Route::get('/types', [TypeController::class, 'all_types']);
Route::get('/types/{id}', [TypeController::class, 'get_type_by_id']);
Route::post('/types', [TypeController::class, 'new_type']);
Route::put('/types/{id}', [TypeController::class, 'modify_type']);
Route::delete('/types/{id}', [TypeController::class, 'remove_type']);

Route::get('/messages', [ContactController::class, 'all_messages']);
Route::get('/messages/{id}', [ContactController::class, 'get_message_by_id']);
Route::post('/messages', [ContactController::class, 'new_message']);
Route::delete('/messages/{id}', [ContactController::class, 'remove_message']);

Route::post('/send-reply/{id}', [MailerController::class, 'compose_reply']);
Route::post('/send-feedback/{id}', [MailerController::class, 'compose_feedback']);

Route::get('/appointments', [AppointmentController::class, 'all_apts']);
Route::get('/appointments/open', [AppointmentController::class, 'all_open_apts']);
Route::get('/appointments/{id}', [AppointmentController::class, 'get_apt_by_id']);
Route::post('/appointments', [AppointmentController::class, 'new_apt']);
Route::put('/appointments/reserve/{id}', [AppointmentController::class, 'reserve_apt']);
Route::put('/appointments/{id}', [AppointmentController::class, 'modify_apt']);
Route::delete('/appointments/{id}', [AppointmentController::class, 'remove_apt']);

Route::get('/bookings', [BookingController::class, 'all_bookings']);
Route::get('/bookings/{id}', [BookingController::class, 'get_booking_by_id']);
Route::post('/bookings', [BookingController::class, 'new_booking']);
Route::put('/bookings/approve/{id}', [BookingController::class, 'approve_booking']);
Route::put('/bookings/{id}', [BookingController::class, 'modify_booking']);
Route::delete('/bookings/{id}', [BookingController::class, 'remove_booking']);