<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClientResource;
use App\Models\Client;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

class ClientController extends BaseController
{
  public function all_clients() {
    $clients = Client::all();

    return $this->sendResponse(ClientResource::collection($clients), "OK");
  }

  public function new_client(Request $request) {
    $input = $request->all();

    $validator = Validator::make($input, [
      "fullName" => "required",
      "dob" => "required",
      "email" => "required|email",
      "phone" => "required",
      "fullAddress" => "required",

    ]);

    if ($validator->fails()) {
      return $this->sendError($validator->errors());
    }

    $client = Client::create($input);

    return $this->sendResponse(new ClientResource($client), "Vendeg felvéve, id $client->id.");
  }

  public function get_client_by_id($id) {
    $client = Client::find($id);

    if (is_null($client)) {
      return $this->sendError("Vendeg nem talalhato.");
    }

    return $this->sendResponse(new ClientResource($client), "A vendeg adatai");
  }

  public function modify_client(Request $request, $id) {
    $input = $request->all();

    $validator = Validator::make($input, [
      "fullName" => "required",
      "dob" => "required",
      "email" => "required|email",
      "phone" => "required",
      "fullAddress" => "required"

    ]);

    if ($validator->fails()) {
      return $this->sendError($validator->errors());
    }

    $client = Client::find($id);
    $client->update($input);

    return $this->sendResponse(new ClientResource($client), "Vendeg adatok frissitve");
  }

  public function remove_client($id) {
    Client::destroy($id);

    return $this->sendResponse([], "Vendeg torolve");
  }
}
