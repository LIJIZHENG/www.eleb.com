<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AddcartController extends Controller
{
    //
    public function addcart(Request $request){
        DB::table('addcarts')->where('regists_id','=',Auth::user()->id)->delete();
        foreach ($request->goodsList as $key=>$goodsList){
            DB::table('addcarts')->insert(
                ['regists_id'=>Auth::user()->id,'menus_id'=>$goodsList,'menus_count'=>$request->goodsCount[$key]]
            );
        }
        return [
            'status'=>'true',
            'message'=>'添加成功'
        ];
    }
    public function cart(){
        $users = DB::table('addcarts')->where('regists_id','=',Auth::user()->id)->get();
        $val=[];
        $a=[];
        $totalCost=0;
        foreach ($users as $user){
            $rows=DB::table('menus')->where('id','=',$user->menus_id)->get();
            foreach ($rows as $row){
                $row->goods_id=$row->id;
                $row->amount=$user->menus_count;
                $a[]=$row;
                $totalCost+=$user->menus_count*$row->goods_price;
                $val['totalCost']=$totalCost;
                $val['goods_list']=$a;
            }
        }
        return $val;
    }
}