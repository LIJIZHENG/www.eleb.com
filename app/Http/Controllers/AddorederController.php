<?php

namespace App\Http\Controllers;

use App\Addoreder;
use App\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AddorederController extends Controller
{
    //
    public function addoreder(Request $request){
        if(Auth::user()){
            $user_id=Auth::user()->id;
            $uniqid=uniqid();
            DB::transaction(function ()use ($request,$uniqid,$user_id) {
                $address=DB::table('addresses')->where('id','=',$request->address_id)->first();
                $addcarts=DB::table('addcarts')->where('regists_id','=',$address->regist_id)->get();
                $addcart=DB::table('addcarts')->where('regists_id','=',$address->regist_id)->first();
                $time=time();
                $menu=DB::table('menus')->where('id','=',$addcart->menus_id)->first();
                $goodsnews=DB::table('goodsnews')->where('id','=',$menu->goodsnews_id)->first();
                $order=Addoreder::create([
                    'order_code' =>$uniqid,
                    'order_birth_time'=>date('Y-m-d H:i:s',$time),
                    'order_status'=>'代付款',
                    'shop_id'=>$goodsnews->id,
                    'shop_name'=>$goodsnews->shop_name,
                    'shop_img'=>$goodsnews->shop_img,
                    'provence'=>$address->provence,
                    'city'=>$address->city,
                    'area'=>$address->area,
                    'detail_address'=>$address->detail_address,
                    'tel'=>$address->tel,
                    'name'=>$address->name,
                ]);
                DB::table('addoreders')
                    ->where('id','=',$order->id)
                    ->update(['regist_id'=>Auth::user()->id]);
                foreach ($addcarts as $addcart){
                    $menus=DB::table('menus')->where('id','=',$addcart->menus_id)->first();
                    DB::table('ints')->insert([
                        'order_id'=>$order->id,
                        'goods_id'=>$menus->id,
                        'goods_name'=>$menus->goods_name,
                        'goods_img'=>$menus->goods_img,
                        'amount'=>$addcart->menus_count,
                        'goods_price'=>$menus->goods_price,
                        'regist_id'=>Auth::user()->id,
                        'created_at'=>date("Y-m-d H:i:s",time())
                    ]);
                }
            });

            $row=DB::table('addoreders')->where('order_code','=',$uniqid)->first();
            $g=DB::table('goodsaccounts')->where('goodsnews_id','=',$row->shop_id)->first();
            $rs=Addoreder::email($g->name,$g->email);
            if($rs){
                return ['status'=>'true',
                    'message'=>'下单成功!',
                    'order_id'=>$row->id
                ];
            }else{
                return ['status'=>'true',
                    'message'=>'下单失败!',
                    'order_id'=>$row->id
                ];
            }

        }else{
           return ['status'=>'false',
            'message'=>'请先登录后再下单!',
            'order_id'=>$request->id];
        }
    }
    //
    public function order(Request $request){
        $rows=DB::table('addoreders')->where('id','=',$request->id)->first();
            $val=DB::table('ints')->where('order_id','=',$request->id)->get();
           $rows->goods_list=$val;
           $a=0;
           foreach ($val as $v){
               $a+=$v->amount*$v->goods_price;
           }
           $rows->order_price=$a;
           $rows->order_address='联系人'.$rows->name.'联系电话'.$rows->tel.'地址'.$rows->provence.$rows->city.$rows->area.$rows->detail_address;
        echo json_encode($rows);
    }
    public function orderList(){
        $rows=DB::table('addoreders')->where('regist_id','=',Auth::user()->id)->get();
        foreach ($rows as $row){
            $val=DB::table('ints')->where('regist_id','=',Auth::user()->id)->get();
            $row->goods_list=$val;
            $a=0;
            foreach ($val as $v){
                $a+=$v->amount*$v->goods_price;
            }
            $row->order_price=$a;
            $row->order_address='联系人'.$row->name.'联系电话'.$row->tel.'地址'.$row->provence.$row->city.$row->area.$row->detail_address;
        }
echo json_encode($rows);


    }
}
