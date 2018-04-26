<?php

namespace App\Http\Controllers;

use App\Regist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class RegistController extends Controller
{
    //
    public function store(Request $request){
        $this->validate($request,[
            'username'=>'required|unique:regists',
            'tel'=>'required|unique:regists'
        ],[
            'username.required'=>'{
                     "status": "false",
                     "message": "用户名为空"
               }',
             'username.unique'=>'{
                     "status": "false",
                     "message": "用户名必须唯一"
               }',
            'tel.required'=>'{
                     "status": "false",
                     "message": "电话号码不能为空"
               }',
            'tel.unique'=>'{
                     "status": "false",
                     "message": "电话号码已存在"
               }'
        ]);
        if(Redis::get('code')!=$request->sms){
            Regist::create([
                    'username'=>$request->username,
                    'tel'=>$request->tel,
                    'password'=>bcrypt($request->password)
            ]);
                echo '{
                     "status": "true",
                     "message": "注册成功"
               }';
            }else{
                echo '{
                     "status": "false",
                     "message": "注册失败"
               }';
            }
    }

    public function check(Request $request){
        if(Auth::attempt(['username'=>$request->name,'password'=>$request->password])){
            return[
                'status'=>"true",
                'message'=>'登录成功'
                ,'user_id'=>Auth::user()->user_id,
                'username'=>Auth::user()->username
            ];
        }else{
            echo '{
                    "status":"false",
                    "message":"登录失败",
                }';
        }
    }
}
