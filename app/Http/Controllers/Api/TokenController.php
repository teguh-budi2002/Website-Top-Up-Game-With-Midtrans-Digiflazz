<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TokenController extends BaseApiController
{
    public function token() {
        $getToken = $this->getAccessApiToken();

        return $this->success_response('Get Token Successfully', $getToken);
    }
}
