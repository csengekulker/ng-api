<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Models\Booking;
use App\Http\Resources\BookingResource;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookingController extends BaseController
{

  public function all_bookings() { 
    $bookings = Booking::all();

    return $bookings;

  }

  public function get_booking_by_id($id) { 
    $booking = Booking::find($id);

    if ( is_null($booking)) {
      return $this->sendError("Foglalas nem talalhato.");
    }

    return $this->sendResponse( new BookingResource($booking), "A foglalas adatai");
  }

  public function new_booking(Request $request)  { 
    $input = $request->all();

    $validator = Validator::make($input, [
      "service_id" => "required",
      "type_id" => "required",
      "client_id" => "required",
      "appointment_id" => "required|unique:bookings"
    ]);

    if ($validator->fails()) {
      return $this->sendError($validator->errors());
    }

    $booking = Booking::create($input);

    return $this->sendResponse( new BookingResource($booking), "Foglalas rogzitve");
  }

  public function approve_booking(Request $request, $id) { 

    $booking = Booking::find($id);
    $apt = Appointment::find($booking['appointment_id']);
    $approved = $booking['isApproved'];
    $open = $apt['isOpen'];

    if (is_null($booking)) { 
      return $this->sendError("Nincs ilyen foglalas.");
    }

    app('App\Http\Controllers\MailerController')->compose_feedback($request, $booking->id);

    if ($approved) {
      return $this->sendError("Mar jovahagyva.");
    } else if (!$open) { 
      return $this->sendError("Mar foglalt.");
    } else {
      $booking->update(['isApproved' => true]);
      $apt->update(['isOpen' => false]);

      return $this->sendResponse( new BookingResource($booking), "Foglalas jovahagyva, idopont lefoglalva, email elkuldve.");

    }
  }

  public function modify_booking(Request $request, $id) { 
    $input = $request->all();

    $validator = Validator::make($input, [
      "service_id" => "required",
      "client_id" => "required",
      "appointment_id" => "required"
    ]);

    if ($validator->fails()) {
      return $this->sendError($validator->errors());
    }

    $booking = Booking::find($id);
    $booking->update($input);

    return $this->sendResponse( new BookingResource($booking), "Foglalas adatok modositva");

  }

  public function remove_booking($id) {
    Booking::destroy($id);

    return $this->sendResponse([], "Foglalas torolve");
  }
}
