<?php

namespace App\Http\Controllers;
use App\Models\Flight;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Login;
use Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    /*function index(Request $request)
    {
        $username= User::where('username', $request->username)->first();
        // print_r($data);
            if (!$username || !Hash::check($request->password, $username->password)) {
                return response([
                    'message' => ['These credentials do not match our records.']
                ], 404);
            }

             $token = $username->createToken('my-app-token')->plainTextToken;

            $response = [
                'username' => $username,
                'token' => $token
            ];

            return response($response, 201);
    }
    function getdata(Request $req){
        $rules = array(
            'username'=>'required|min:4',
            'email'=>'required',
            'password'=>'required|min:6',
            'confirm_password'=>'required|same:password'
        );
        $validator = Validator::make($req->all(),$rules);
        if ($validator->fails()){
            return response()->json($validator->errors(),401);
        }
        else{
            $login = new Login;
            $login->username = $req->username;
            $login->email = $req->email;
            $login->password = $req->password;
            $login->confirm_password = $req->confirm_password;
            $result=$login->save();
            if($result){
                return ["Result"=>"User is successfully Registered"];
            }else{
                return ["Result"=>"Operation failed"];
            }
        }
    }*/

    public function register(Request $req){
        $validator = $req->validate(
            [
                'username'=>'required',
                'email'=>['required','email'],
                'password'=>['required','min:6','confirmed']
            ]);
            $user = User::create($validator);

            return response()->json(
                [
                'user' => $user,
                'message' => 'User created Successfully',
                'status' => 1
                ]);

    }

    public function login_user(Request $req){
        $validator = $req->validate(
            [
                'username'=>'required',
                'password'=>'required',
            ]);
            $user = User::where(['username'=>$validator['username'],'password'=>$validator['password']])->first();
           // $token = $user->createToken("authtoken")->accessToken;

            return response()->json(
                [
                //'token' => $token,
                'user' => $user,
                'message' => 'User logged in Successfully',
                'status' => 1
                ]);
    }
    public function import(Request $request){
        $file = $request->file('file');
        $fileContents = file($file->getPathname());

        foreach ($fileContents as $line) {
            $data = str_getcsv($line);

            Flight::create([
                'flight_id' => $data[0],
                'flight_name' => $data[1],
                'arrival' => $data[2],
                'destination' => $data[3],

                // Add more fields as needed
            ]);
        }
        return ["success"=> "CSV file imported successfully."];
    }
    public function export($type)
    {
        $flights = Flight::all();
        if($type=='csv'){
            $csvFileName = 'flight_data.csv';
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $csvFileName . '"',
            ];

            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Flight_id','Flight_name', 'Arrival', 'Destination']); // Add more headers as needed

            foreach ($flights as $flight) {
                fputcsv($handle, [$flight->flight_id, $flight->flight_name, $flight->arrival, $flight->destination]);
            }
            fclose($handle);

            return Response::make('', 200, $headers);
    }
    else if($type=='pdf'){

        Storage::put('Flight_data.pdf', $flights);
        return ["Result" => "File has been downloaded"];
    }
    else if($type=='xlsx'){
        Storage::put("Flight_data.xlsx", $flights);
        return ["Result" => "File has been downloaded"];

    }
    else if($type=='json'){
        return Response::json($flights);
        }

    }
}
