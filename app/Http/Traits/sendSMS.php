<?php

namespace App\Http\Traits;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

trait sendSMS
{

    public function send_alert_sms_old($token, $destinataire, $message)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.orange.com/smsmessaging/v1/outbound/tel%3A%2B22549541652/requests",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "{\r\n\t\"outboundSMSMessageRequest\":\r\n\t{\r\n        \"address\": \"tel:".$destinataire."\", \r\n        \"senderAddress\":\"tel:+22549541652\", \r\n        \"outboundSMSTextMessage\":{ \r\n            \"message\": \"".$message."\" \r\n        } \r\n    }\r\n}",
        CURLOPT_HTTPHEADER => array(
            "authorization: " . $token,
            "cache-control: no-cache",
            "content-type: application/json",
            "postman-token: bc5a5ac1-6480-6d74-8063-859470ec23d9"
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
        return false;
        } else {
        return json_decode($response);
        }

    }

    public function get_solde_sms($token)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.orange.com/sms/admin/v1/contracts",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "authorization: " . $token,
            "content-type: application/json"
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
        return false;
        } else {
        return json_decode($response);
        }

    }


    //----------new sms code ---------------------------------------------------
    public function send_alert_sms($token, $recipient, $message)
    {
        $url = 'https://app.yellikasms.com/api/v3/sms/send';
        $sender_id = 'Babimo';
        $type = 'plain';
        $data = array(
            'recipient' => $recipient,
            'sender_id' => $sender_id,
            'type' => $type,
            'message' => $message
        );
        $payload = json_encode($data);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: ' . $token,
            'Content-Type: application/json',
            'Accept: application/json'
        ));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        if(curl_errno($ch)){
            echo 'Erreur cURL : ' . curl_error($ch);
        }
        curl_close($ch);
        echo $response;
    }

    public function get_token()
    {
        $token = 'Bearer 32|3WDoqwxhzYC6CG3EliMb7CBdRXPb8p34zwqjEFcG';
        return $token;
    }

    public function sendSmsOtp($tel, $msg)
    {
        $token = $this->get_token();
        if ($token) {
          $this->send_alert_sms($token, '225'.$tel, $msg);
        }

    }
   //----------------end send ---------------------------------------------


    public function get_token_old()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.orange.com/oauth/v3/token",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "grant_type=client_credentials",
        CURLOPT_HTTPHEADER => array(
            "authorization: Basic dzdneEFEQlY5c3Z2NkVSNE1nTXhTSklGeFpNZzlEOTY6SEFzNDVGZ0FSd2dLQkl4cw==",
            "cache-control: no-cache",
            "accept: application/json",
            "content-type: application/x-www-form-urlencoded",
            "postman-token: ed01987e-95c6-1c04-8cc2-9bc2efd2b6eb"
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
        return false;
        } else {
            $response = json_decode($response);
        return $response->token_type . " " . $response->access_token;
        }

    }


    public function getSmsOtp()
    {
        $token = $this->get_token();
      //  dd($this->get_solde_sms($token));
      $result = $this->get_solde_sms($token);

      return $result;

    }


}