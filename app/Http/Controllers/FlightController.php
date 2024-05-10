<?php

namespace App\Http\Controllers;
use App\Models\Flight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
class FlightController extends Controller
{
    //
    function list($id=null){
        return $id?Flight::find($id):Flight::all();
    }
    function add(Request $req){
        $flight= new Flight;
        $flight->flight_name = $req->flight_name;
        $flight->arrival = $req->arrival;
        $flight->destination = $req->destination;
        $result=$flight->save();
        if($result){
            return ["Result","Data has been saved"];
        }
        else{
            return ["Result","Operation failed"];
        }
    }
    function update(Request $req , $id){
        $flight = Flight::find($id);
        $flight->flight_name=$req->flight_name;
        $flight->arrival=$req->arrival;
        $flight->destination=$req->destination;
        $result=$flight->save();
        if($result){
            return ["Result"=>"Updation is successful"];
        }else{
            return ["Result"=>"Operation failed"];
        }
    }
    function search($type,$name){
        if($type=='flightname'){
            return Flight::where("flight_name","like","%".$name."%")->get();
        }
        else if($type=='arrival'){
            return Flight::where("arrival","like","%".$name."%")->get();
        }
        else if($type=='destination'){
            return Flight::where("destination","like","%".$name."%")->get();
        }
    }

    /*function searchGlobal($name){
        return Flight::where(['flight_name',"like","%".$name."%"],
                            ['arrival',"like","%".$name."%"],
                            ['destination',"like","%".$name."%"]
                    )->get();
    }
*/
    function delete($flight_id){
        $flight=Flight::find($flight_id);
        $result=$flight->delete();
        if($result){
            return ["Result"=>"Record ".$flight_id." is deleted"];
        }
        else{
            return ["Result"=>"Operation failed"];
        }
    }
    function testData(Request $req){
        $rules = array(
            "flight_name"=>"required|min:5",
            "arrival"=>"required",
            "destination"=>"required"
        );
        $validator = Validator::make($req->all(),$rules);
        if ($validator->fails()){
            return response()->json($validator->errors(),401);
        }
        else{
            $flight = new Flight;
            $flight->flight_name=$req->flight_name;
            $flight->arrival=$req->arrival;
            $flight->destination=$req->destination;
            $result=$flight->save();
            if($result){
                return ["Result"=>"Validation is successful and Flight data is saved"];
            }else{
                return ["Result"=>"Operation failed"];
            }
        }
    }
}
