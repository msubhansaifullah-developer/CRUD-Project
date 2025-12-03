<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function sendresponse($result,$message){
        $response=[
            'success'=>true,
            'data'=>$result,
            'message'=>$message
        ];
        return response()->json($response,200);
    }
    public function senderror($error,$errormessage=[],$code=404){
         $response=[
            'success'=>false,
            'data'=>$error,   
        ];
        if(!empty($errormessage)){
            $response['data']=$errormessage;
        }
        return response()->json($response,$code);
    }
}
