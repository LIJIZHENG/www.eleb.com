<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    //
    public function goodsnews(){
       $rows=DB::table('goodsnews')->get();
        return $rows;
    }
    public function goodsaccounts(Request $request){
        $goodsnews=DB::table('goodsnews')->where('id','=',$request->id)->get();
        foreach ($goodsnews as $goodsnew){

        }
        $goodsnew->service_code=4.6;
        $goodsnew->foods_code=4.4;
        $goodsnew->high_or_low=true;
        $goodsnew->h_l_percent=30;
        $evaluate=[
            [
                "user_id"=> 12344,
                "username"=> "w******k",
                "user_img"=> "http://www.homework.com/images/slider-pic4.jpeg",
                "time"=> "2017-2-22",
                "evaluate_code"=> 1,
                "send_time"=> 30,
                "evaluate_details"=> "不怎么好吃"
            ],
            [
                "user_id"=>12344,
                "username"=> "w******k",
                "user_img"=> "http://www.homework.com/images/slider-pic4.jpeg",
                "time"=> "2017-2-22",
                "evaluate_code"=> 4.5,
                "send_time"=> 30,
                "evaluate_details"=> "很好吃"
            ]
            ];
        $menus=DB::table('menus')->where('goodsnews_id','=',$goodsnew->id)->get();
        foreach ($menus as $menu){

        }
        $menu_classes=DB::table('menu_classes')->where('id','=',$menu->menuclass_id)->get();
        foreach ($menu_classes as $menu_class1){

        }
        $menu_class1->goods_list=$menus;
        $goodsnew->evaluate=$evaluate;
        $goodsnew->commodity=$menu_classes;
        return json_encode($goodsnew);
    }
}
