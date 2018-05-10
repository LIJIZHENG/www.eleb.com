<?php

namespace App\Http\Controllers;

use App\Goodsnews;
use App\SphinxClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    //
    public function goodsnews(Request $request){
        $cl = new SphinxClient();
        $cl->SetServer ( '127.0.0.1', 9312);
//$cl->SetServer ( '10.6.0.6', 9312);
//$cl->SetServer ( '10.6.0.22', 9312);
//$cl->SetServer ( '10.8.8.2', 9312);
        $cl->SetConnectTimeout ( 10 );
        $cl->SetArrayResult ( true );
// $cl->SetMatchMode ( SPH_MATCH_ANY);
        $cl->SetMatchMode ( SPH_MATCH_EXTENDED2);
        $cl->SetLimits(0, 1000);
        $info =$request->keyword;
//        $info ='lijizheng';
        $res = $cl->Query($info,'shops');//shopstore_search
//print_r($cl);
//        dd($res);
        if($res['total']){
            $id=[];
            foreach ($res['matches'] as $match){
//                $row=Goodsnews::where('id','=',$match['id'])->first();
//                $rows[]=$row;
             $id[]=$match['id'];
            }
            $rows = DB::table('goodsnews')
                ->whereIn('id', $id)
                ->get();
        }else{
//            $query=$request->query();
            $rows=DB::table('goodsnews')->get();
        }

        return $rows;
    }
    public function goodsaccounts(Request $request){
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
        $goodsnews=DB::table('goodsnews')->where('id','=',$request->id)->get();
        foreach ($goodsnews as $goodsnew){
            $goodsnew->service_code=4.6;
            $goodsnew->foods_code=4.4;
            $goodsnew->high_or_low=true;
            $goodsnew->h_l_percent=30;
            $goodsnew->evaluate=$evaluate;
            $menus=DB::table('menus')->where('goodsnews_id','=',$goodsnew->id)->get();
            foreach ($menus as $menu){
                $menu->goods_id=$menu->id;
            }
            //dd($menu);
            $menu_classes=DB::table('menu_classes')->where('goodsnews_id','=',$menu->goodsnews_id)->get();
            foreach ($menu_classes as $menu_class1){
                $menu_class1->goods_list=$menus;
            }
            $goodsnew->commodity=$menu_classes;
        }

        return json_encode($goodsnew);
    }
}
