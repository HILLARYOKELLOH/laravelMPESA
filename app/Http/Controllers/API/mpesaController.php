<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class mpesaController extends Controller
{

    //public $accessToken;

    public function generateAccessToken()
    {
        $consumer_key = "6AG6HS5IeyTAHZ0Jdl1itsKSjQbksKc0";
        $consumer_secret = "SJLIyjWFEeTDveY6";
        $credentials = base64_encode($consumer_key . ":" . $consumer_secret);

        $url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);

        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Basic ' . $credentials)); //setting a custom header
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $curl_response = curl_exec($curl);

        $access_token = json_decode($curl_response);

        return $access_token->access_token;
    }



    public function STKPush()
    {

        $BusinessShortCode = 174379;
        $passkey = 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';
        $timestamp = Carbon::rawParse('now')->format('YmdHms');

        $password = base64_encode($BusinessShortCode . $passkey . $timestamp);
        $Amount = 1;
        $PartyA = 254111781133; //the one paying
        $PartyB = 174379;


        $url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';


        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);

        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization:Bearer ACCESS_TOKEN')); //setting custom header


        $curl_post_data = array(
            //Fill in the request parameters with valid values
            'BusinessShortCode' => $BusinessShortCode,
            'Password' => $password,
            'Timestamp' => $timestamp,
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount"' => $Amount,
            'PartyA' => $PartyA,
            'PartyB' => $PartyB,
            'PhoneNumber' => 254111781133,
            'CallBackURL' => 'https://ba07-105-163-2-81.eu.ngrok.io/web-socket/',
            'AccountReference' => 'E-market ',
            'TransactionDesc' => 'Testing stkpush'
        );

        $data_string = json_encode($curl_post_data);


        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

        $curl_response = curl_exec($curl);


        return $curl_response;
    }
}
