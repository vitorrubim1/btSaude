<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\PushDemo;
use App\User;
use Auth;
use Notification;
use OneSignal;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;

class PushController extends Controller
{
    //
    public function __construct(){
        // $this->middleware('auth');
      }
      /**
       * Store the PushSubscription.
       * 
       * @param \Illuminate\Http\Request $request
       * @return \Illuminate\Http\JsonResponse
       */
      public function store(Request $request){
          $this->validate($request,[
              'endpoint'    => 'required',
              'keys.auth'   => 'required',
              'keys.p256dh' => 'required'
          ]);
          $endpoint = $request->endpoint;
          $token = $request->keys['auth'];
          $key = $request->keys['p256dh'];
          $user = Auth::user();
          $user->updatePushSubscription($endpoint, $key, $token);
          
          return response()->json(['success' => true],200);
      }

      public function push(){
        // OneSignal::sendNotificationToAll("Some Message", $url = null, $data = null);
        // User::all();
        // Notification::send(User::all(),new PushDemo);
        // return redirect()->back();
        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60*20);

        $notificationBuilder = new PayloadNotificationBuilder('Chamada de Vídeo de Luiz Inácio');
        $notificationBuilder->setBody('Toque para Aceitar')
                            ->setIcon('https://image.flaticon.com/icons/svg/1868/1868026.svg')
                            ->setSound('default');

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData(['opentok_session_id' => '2_MX40NTE5MDYyMn5-MTU3NTE3NjY4NzM3Mn54YWFtVENKM1hMRUVJME51bFZlR1JWRS9-UH4', 'opentok_token' => 'T1==cGFydG5lcl9pZD00NTE5MDYyMiZzaWc9ZDEyYWY3ODU5OTdiMWI1ODNkOTYzYzI4NmFjMjJjODEyMDg2ZTQ2MDpzZXNzaW9uX2lkPTJfTVg0ME5URTVNRFl5TW41LU1UVTNOVEUzTmpZNE56TTNNbjU0WVdGdFZFTktNMWhNUlVWSk1FNTFiRlpsUjFKV1JTOS1VSDQmY3JlYXRlX3RpbWU9MTU3NTE3NjY4NyZyb2xlPXB1Ymxpc2hlciZub25jZT0xNTc1MTc2Njg3LjM3NjYxMDgwNzczMDQ3JmluaXRpYWxfbGF5b3V0X2NsYXNzX2xpc3Q9', 'call_id' => 76, 'opentok_apikey' => 45190622]);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        $token = "fGNWXzs6gjY:APA91bE2idWkCrK1PFRwj7QateSwupV0n34GoKlijKeFw5lMVgiqicjX2EJtOOygCvdhETT6OfY9G4UMZ87-jnBRBBKgWwco38409stz0x17Z74yDEKrL6I8RNGKeAl69y5EfM2cBiS8";

        $downstreamResponse = FCM::sendTo($token, $option, $notification, $data);

        echo $downstreamResponse->numberSuccess();
        $downstreamResponse->numberFailure();
        $downstreamResponse->numberModification();

        // return Array - you must remove all this tokens in your database
        // print_r($downstreamResponse->tokensToDelete());

        // return Array (key : oldToken, value : new token - you must change the token in your database)
        // print_r($downstreamResponse->tokensToModify());

        // return Array - you should try to resend the message to the tokens in the array
        // print_r($downstreamResponse->tokensToRetry());

        // return Array (key:token, value:error) - in production you should remove from your database the tokens
        // print_r($downstreamResponse->tokensWithError());
    }
}
