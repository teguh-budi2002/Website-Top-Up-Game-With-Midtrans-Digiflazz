<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CustomAccessApiToken;

class BaseApiController extends Controller
{
    public function base_response($is_success, $code, $messages, $data = null){
        return response()->json([
            'success' => $is_success,
            'code'  => $code,
            "message" => $messages,
            "data" => $data
        ])->withHeaders([
            'Content-Type'   => "application/json",
        ]);
    }

    public function failed_response($data, $status = 500)
    {
        $message = json_decode($data);
        if(!is_object($message)){
            $message = $data;
        }

        return $this->base_response(FALSE, $status,$message); 
    }

    public function success_response($messages, $status = 200, $data = [])
    {
        return $this->base_response(TRUE, $status, $messages, $data);
    }

    protected function getAccessApiToken() {
        $accessToken = CustomAccessApiToken::first();
        if ($accessToken) {
            return $accessToken->token;
        }

        return null;
    }
}
