<?php

use Illuminate\Http\Request;
use App\Call;
use App\Events\Alert;
// use Log;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('login', 'api\UserController@login');
Route::post('register', 'api\UserController@register');
// Route::post('register', 'api\RegisterController@register');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('test',function(Request $request){

    Log::info($request->all());

    $call = new Call;
    $call->patient_id = $request->patient_id;
    $call->patient_name = $request->patient_name;
    $call->profession = $request->profession;
    $call->opentok_session = $request->opentok_session;
    $call->opentok_token = $request->opentok_token;
    $call->save();

    return response()->json(['call_id'=> $call->id]);
});

Route::group(['middleware' => 'auth:api'], function(){
    Route::get('call', 'api\CallController@index');
    Route::get('call/{id}', 'api\CallController@show');
    Route::post('call', 'api\CallController@store');
    Route::get("notification/toggle/{status}", "api\NotificationController@toggle");
});