<?php

namespace App\Http\Controllers;

use App\Regist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Validation\Validator;

class RegistController extends Controller
{
    //
    public function store(Request $request){
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'username' => 'required|unique:regists|max:255',
            'tel' => 'required|unique:regists',
        ],[
            'username.required'=>"用户名不能为空!",
            'username.unique'=>"用户名已存在!",
            'username.max'=>'最大长度255!',
            'tel.required'=>'电话号码不能为空!',
            'tel.unique'=>'电话号码以存在!'
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
             return [
                "status"=>"false",
                "message"=>$errors->first()
            ];
        }
        if(Redis::get('code_'.$request->tel)==$request->sms){
            Regist::create([
                    'username'=>$request->username,
                    'tel'=>$request->tel,
                    'password'=>bcrypt($request->password)
            ]);
                return [
                     "status"=> "true",
                     "message"=> "注册成功"
               ];
            }else{
                return [
                     "status"=>"false",
                     "message"=>"验证码不正确!"
               ];
            }
    }

    public function check(Request $request){
        if(Auth::attempt(['username'=>$request->name,'password'=>$request->password])){
            return[
                'status'=>"true",
                'message'=>'登录成功',
                'user_id'=>Auth::user()->id,
                'username'=>Auth::user()->username
            ];
        }else{
            return[
                    "status"=>"false",
                    "message"=>"登录失败",
                ];
        }
    }
}
