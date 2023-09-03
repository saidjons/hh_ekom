<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class BaseApiController extends BaseController
{
   

    public function success($message,array $data,$headers = []){
        return response(
            [
                "data"=>$data,
            ]
            
            ,200,$headers);
    }
    public function error($message,array $error,$headers = []){
        return response([
            "message"=>$message,
            "error"=>$error
        ],401,$headers);
    }
}
