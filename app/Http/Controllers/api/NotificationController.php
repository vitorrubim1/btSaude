<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Log;
use Auth;

class NotificationController extends Controller
{
    public function toggle($status){
        if(!is_numeric($status) || $status !== 1 || $status !== 2){
            return response()->json(["error" => "Bad Request"], 400);
        }
        User::where("id", Auth::user()->id)->update(["notification_status" => $status]);
        return response(null, 204);
    }
}
