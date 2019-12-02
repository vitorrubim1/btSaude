<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Log;

class RegisterController extends Controller
{
    //
    public function register(Request $request)
    {

        // $validator = Validator::make($request->all(), [
        //     "name" => "required",
        //     "taxid" => "required",
        //     "telephone" => "required",
        //     "cellphone" => "required",
        //     "document" => "required",
        //     "profession" => "required",
        //     "email" => "required|email",
        //     "password" => "required",
        //     "front" => "required|image|mimes:jpeg,png,jpg",
        //     "back" => "required|image|mimes:jpeg,png,jpg"
        // ]);

        // if($validator->fails()){
        //     return response()->json(["error" => "Bad Request"], 400);
        // }

        // if(!$request->hasFile("front") || !$request->file("front")->isValid()){
        //     return response()->json(["error" => "Bad Request"], 400);
        // }

        // if(!$request->hasFile("back") || !$request->file("back")->isValid()){
        //     return response()->json(["error" => "Bad Request"], 400);
        // }

        $body = $request->all();
        $body["password"] = bcrypt($body["password"]);
        
        Log::info("Test");
        Log::info("front", $request->file('front'));
        Log::info("back", $request->file('back'));

        $body["photo_front"] = md5(time().uniqid().time()).$request->front->extension();
        $body["photo_back"] = md5(time().uniqid().time()).$request->back->extension();

        move_uploaded_file($_FILES["front"]["tmp_name"], public_path("documents")."/".$body["photo_front"]);
        move_uploaded_file($_FILES["back"]["tmp_name"], public_path("documents")."/".$body["photo_back"]);
    
        $user = User::create($body);

        if(!$user){
            return response()->json(["error" => "Internal Server Error"], 500);
        }

        return response()->json(["message" => "Registro Criado com Sucesso!", "path" => public_path("documents"), "front" => $body["photo_front"]], 200);
    }
}
