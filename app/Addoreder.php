<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class Addoreder extends Model
{
    //
    protected $fillable = [
        'order_code', 'order_birth_time', 'order_status','shop_id','shop_name','shop_img','provence','city','area','detail_address','tel','name'
    ];
    public static function email($name,$email){
        Mail::send(
            'mail',//邮件视图模板
            ['name'=>$name],
            function ($message)use($email){
                $message->to($email)->subject('订单确认');
            }
        );
        return true;
    }
}
