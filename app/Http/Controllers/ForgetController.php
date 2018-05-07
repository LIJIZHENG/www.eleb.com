<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class ForgetController extends Controller
{
    //
    public function forget(Request $request){
        $users = DB::table('regists')->where('tel','=',$request->tel)->first();
        if($users->username){
            if(Redis::get('code_'.$request->tel)==$request->sms){
                DB::table('regists')
                    ->where('tel','=',$request->tel)
                    ->update(['password' =>bcrypt($request->password)]);
                return[
                    'status'=>'true',
                    'message'=>'重置密码成功!'
                ];
            }else{
                return[
                    'status'=>'false',
                    'message'=>'验证码不正确!'
                ];
            }
        }else{
            return[
                'status'=>'false',
                'message'=>'改电话号码没被注册请先注册!'
            ];
        }
    }
}
