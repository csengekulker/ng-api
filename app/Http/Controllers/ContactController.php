<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Http\Resources\MessageResource;
use Illuminate\Support\Facades\Validator;

class ContactController extends BaseController
{
    public function all_messages() {

        $messages = Message::all();

        return $this->sendResponse(MessageResource::collection($messages), "OK");
    }

    public function get_message_by_id($id) {
        $message = Message::find($id);

        if (is_null($message)) {
            return $this->sendError("Uzenet nem letezik.");
        }

        return $this->sendResponse( new MessageResource($message), "Uzenet");
    }

    public function new_message(Request $request) {
        $input = $request->all();
    
        $validator = Validator::make($input, [
          "name" => "required",
          "email" => "required|email",
          "subject" => "required",
          "body" => "required",
    
        ]);
    
        if ($validator->fails()) {
          return $this->sendError($validator->errors());
        }
    
        $message = Message::create($input);
    
        return $this->sendResponse(new MessageResource($message), "Uzenet rogzitve");
    }

    public function remove_message($id) {
        Message::destroy($id);

        return $this->sendResponse([], "Uzenet torolve");
    }

}
