<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

// use App\SellingPriceGroup;

use AfricasTalking\SDK\AfricasTalking;
use GuzzleHttp\Exception\GuzzleException;


class SmsController extends Controller
{

    public function sendSMS(Request $request)
    {
        $inputs = $request->all();
        //echo "Sent!";
        $username = 'ultimatepos'; // use 'sandbox' for development in the test environment
        $apiKey   = '8e19cfc29a0d640af1e2c1641edddd2209002fd43cd2d6acd246cd72446689fb'; // use your sandbox app API key for development in the test environment
        $AT       = new AfricasTalking($username, $apiKey);
        
        // Get one of the services
        $sms      = $AT->sms();
        
        // Use the service
        $result   = $sms->send([
            'to'      => $inputs['phone'],
            'message' => $inputs['text']
        ]);
        
        echo json_encode($result);        
    }
}
