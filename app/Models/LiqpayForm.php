<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Liqpay;

class LiqpayForm extends Model {
    
    public static function getPayForm(){
        $micro = sprintf("%06d",(microtime(true) - floor(microtime(true))) * 1000000); 
        $number = date("YmdHis"); //Все вместе будет первой частью номера ордера
        $order_id = $number.$micro; //Формирование номера ордера таким образом…
    
        $merchant_id='i71121907678'; 
        $signature="IswAVCNLPFv5uHN5hpdNt3sMPgksd6m29Skp7NKS"; 
        $price = $_GET['price'];
        $liqpay = new Liqpay($merchant_id, $signature);
        $html = $liqpay->cnb_form(array(
            'version' => '3',
            'amount' => "$price",
            'currency' => 'UAH', 
            'description' => "Назначение платежа укажите свое", 
            'order_id' => $order_id
        ));
        
        echo $html;
    }
}