<?php

namespace App\Http\Controllers\APIControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Twilio\Rest\Client;
use Twilio\Jwt\ClientToken;
use Storage;

class SmsController extends Controller
{
    public function sendSms(Request $request, $toPhoneNumber)
    {
        $accountSid = config('app.twilio')['TWILIO_ACCOUNT_SID'];
        $authToken = config('app.twilio')['TWILIO_AUTH_TOKEN'];
        $appSid = config('app.twilio')['TWILIO_APP_SID'];
        $appPhoneNumber = config('app.twilio')['TWILIO_PHONE_NUMBER'];
        $client = new Client($accountSid, $authToken);
        $smsCode = rand(1000, 9999);
        try {
            // Use the client to do fun stuff like send text messages!
            $client->messages->create(
                // the number you'd like to send the message to
                $toPhoneNumber,
                array(
                    // A Twilio phone number you purchased at twilio.com/console
                    'from' => $appPhoneNumber,
                    // the body of the text message you'd like to send
                    'body' => $smsCode
                )
            );

            // ray: store verification code on server
            Storage::put('verification', $smsCode);

            return response([
                'success' => true,
                'message' => 'SMS sent successfully',
                'serverVerification' => $smsCode, // ray test remove this in real version
                'status_code' => 200
            ]);
        } catch (Exception $e) {
            return response([
                'success' => false,
                'message' => $e->getMessage(),
                'status_code' => 400
            ]);
        }
    }
}
