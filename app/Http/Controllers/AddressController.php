<?php

namespace App\Http\Controllers;

use App\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    //
   public function address(Request $request){
       $validator = Validator::make($request->all(), [
           'tel' => 'required|max:11',
       ],[
           'tel.required'=>'电话到吗不能为空!',
           'tel.max'=>'电话号码不能大于11位!'
       ]);

       if ($validator->fails()) {
           $errors = $validator->errors();
           return [
               'status'=>'false',
               'message'=>$errors->first()
           ];
       }
       DB::table('addresses')->insert(
           ['name' =>$request->name, 'tel' =>$request->tel,'provence'=>$request->provence,'city'=>$request->city,'area'=>$request->area,'detail_address'=>$request->detail_address,'regist_id'=>Auth::user()->id]
       );
       return [
           'status'=>'true',
           'message'=>'添加成功!'
       ];
   }
   public function addlist(){
       $rows=DB::table('addresses')->where('regist_id','=',Auth::user()->id)->get();
       return $rows;
   }
   public function editress(){
      $row=DB::table('addresses')->where('regist_id','=',Auth::user()->id)->first();
       echo json_encode($row);
   }
   public function edit(Request $request){
       $validator = Validator::make($request->all(), [
           'tel' => 'required|max:11',
       ],[
           'tel.required'=>'电话到吗不能为空!',
           'tel.max'=>'电话号码不能大于11位!'
       ]);

       if ($validator->fails()) {
           $errors = $validator->errors();
           return [
               'status'=>'false',
               'message'=>$errors->first()
           ];
       }
       DB::table('addresses')
           ->where('regist_id','=',Auth::user()->id)
           ->update(['name' =>$request->name, 'tel' =>$request->tel,'provence'=>$request->provence,'city'=>$request->city,'area'=>$request->area,'detail_address'=>$request->detail_address]);
       return ['status'=>'true','message'=>'修改成功!'];
   }
}
