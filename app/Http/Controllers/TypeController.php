<?php

namespace App\Http\Controllers;
use App\Http\Controllers\BaseController;
use App\Models\Type;
use App\Http\Resources\TypeResource;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TypeController extends BaseController
{
    public function all_types() { 

        $types = Type::all();

        return $this->sendResponse(TypeResource::collection($types), "OK");
    }

    public function get_type_by_id($id) {
        $type = Type::find($id);

        if (is_null($type)) {
            return $this->sendError("Nincs ilyen tipus");
        }

        return $type;
    }

    public function get_types_by_serviceid($serviceId) { 
        $types = Service::find($serviceId)->type;
        $typeDuration = Type::find(1)->price;
        return $types;
    }


    public function new_type(Request $request) { 
        $input = $request->all();

        $validator = Validator::make($input, [
            "name" => "required",
            "duration" => "required",
            "price" => "required"
        ]);

        if ($validator->fails()) {
            return $this->sendError( $validator->errors());
        }

        $type = Type::create($input);

        return $this->sendResponse( new TypeResource($type), "Tipus felveve");
    }

    public function modify_type(Request $request, $id) { 
        $input = $request->all();

        $validator = Validator::make( $input, [
          "name" => "required",
          "duration" => "required",
          "price" => "required"

        ]);
    
        if ($validator->fails()) {
          return $this->sendError( $validator->errors());
        }
    
        $type = Type::find($id);
        $type->update($input);
    
        return $this->sendResponse(new TypeResource($type), "Szolgaltatas adatok frissitve");
    }

    public function remove_type($id) { 
        Type::destroy($id);

        return $this->sendResponse([], "Tipus torolve");
    }

} 
