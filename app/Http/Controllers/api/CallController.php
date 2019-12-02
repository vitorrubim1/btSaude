<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Call;
use Log;
use Auth;

class CallController extends Controller
{
    //
    public function index(){
        $data['records'] = Call::where('doctor_id', Auth::user()->id)->get();
        return response()->json($data, 200);
    }

    public function show($id){
        $data['row'] = Call::where('id', $id)->first();
        return response()->json($data, 200);
    }

    public function store(Request $request){
        Log::info($request->all());
        $call = Call::where('id',$request->id)->first();

        if($call->doctor_id):
            $response = [
                'data' => false
            ];
            return response()->json($response, 401);
        else:
            $data['doctor_id'] = Auth::user()->id;
            $data['status'] = 1;
            $data['type'] = 1;
            $update = Call::find($request->id)->update($data);
            $response = [
                'data' => true
            ];
            return response()->json($response, 200);            
        endif;                
    }
}
