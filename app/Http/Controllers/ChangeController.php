<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ChangeController extends Controller
{
    //
    public function change(Request $request){
        if (Hash::check($request->oldPassword,Auth::user()->password)){
            DB::table('regists')
                ->where('id','=',Auth::user()->id)
                ->update(['password' =>bcrypt($request->newPassword)]);
            return [
                'status'=>'true',
                'message'=>'修改成功!'
            ];
        }else{
            return [
                'status'=>'false',
                'message'=>'旧密码不正确'
            ];
        }
    }
}
