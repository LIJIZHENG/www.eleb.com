<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PayController extends Controller
{
    //
    public function pay(){
        return [
            'status'=>'true',
            'message'=>'支付成功'
        ];
    }
}
