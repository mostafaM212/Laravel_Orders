<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    public function sendResponse($response , $status=200,$code = 200){

        return response()->json([
            'status' => $status,
            'code' => $code,
            'data' => $response
        ], $status);
    }

}
