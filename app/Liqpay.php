<?php
namespace App;
use App\Models\Billing\Balance;
use App\Models\Billing\BalanceTransactions;
use App\Models\Billing\BalanceProjects;
use App\Models\Billing\Order;

use App\Jobs\RejectedBalance;
use App\Jobs\ApprovedBalance;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
/**
 * Liqpay Payment Module
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category LiqPay
 * @package liqpay/liqpay
 * @version 3.0
 * @author Liqpay
 * @copyright Copyright (c) 2014 Liqpay
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 *
 * EXTENSION INFORMATION
 *
 * LIQPAY API https://www.liqpay.com/ru/doc
 *
 */
/**
 * Payment method liqpay process
 *
 * @author Liqpay <support@liqpay.com>
 */
class LiqPay
{
private $_api_url = 'https://www.liqpay.com/api/';
private $_checkout_url = 'https://www.liqpay.com/api/checkout';
protected $_supportedCurrencies = array('EUR','UAH','USD','RUB','RUR');
private $_public_key;
private $_private_key;


protected $aliasPendingTrans = ['','wait_sender','password_verify', 'wait_accept'];
/**
 * Constructor.
 *
 * @param string $public_key
 * @param string $private_key
 *
 * @throws InvalidArgumentException
 */
public function __construct($public_key, $private_key)
{
    if (empty($public_key)) {
        throw new InvalidArgumentException('public_key is empty');
}
    if (empty($private_key)) {
        throw new InvalidArgumentException('private_key is empty');
}
    $this->_public_key = $public_key;
    $this->_private_key = $private_key;
}
/**
 * Call API
 *
 * @param string $url
 * @param array $params
 *
 * @return string
 */

    public function Success(Request $request) {
        //пришёл любой запрос, пишем его в лог файл на сервер
        Log::info('---WayForPayController@Success----------------------------------------------------- ', [$request]);
        return redirect(route('mybalance.index'))->with('success_message', ($request->user()?$request->user()->name:'') . ' Ваш платеж успешно проведен.');
    }

    public function Fail(Request $request) {
        //пришёл любой запрос, пишем его в лог файл на сервер
        Log::info('---WayForPayController@Fail----------------------------------------------------- ', [$request]);
        return redirect(route('mybalance.index'))->with('warning_message', ($request->user()?$request->user()->name:'') . ' Ваш платеж отменен..');
    }


//public function api($path, $params = array())
//{
//    if(!isset($params['version'])){
//        throw new InvalidArgumentException('version is null');
//}
//    $url = $this->_api_url . $path;
//    $public_key = $this->_public_key;
//    $private_key = $this->_private_key;
//    $data = base64_encode(json_encode(array_merge(compact('public_key'), $params)));
//    $signature = base64_encode(sha1($private_key.$data.$private_key, 1));
//    $postfields = http_build_query(array(
//        'data' => $data,
//        'signature' => $signature
//    ));
//    $ch = curl_init();
//    curl_setopt($ch, CURLOPT_URL, $url);
//    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//    curl_setopt($ch, CURLOPT_POST, 1);
//    curl_setopt($ch, CURLOPT_POSTFIELDS,$postfields);
//    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
//    $server_output = curl_exec($ch);
//    curl_close($ch);
//    return json_decode($server_output);
//
//}

    public function Api($path, $params = array()) {
        if(!isset($params['version'])){
            throw new InvalidArgumentException('version is null');
    }
        $url = $this->_api_url . $path;
        $public_key = $this->_public_key;
        $private_key = $this->_private_key;
        $data = base64_encode(json_encode(array_merge(compact('public_key'), $params)));
        $signature = base64_encode(sha1($private_key.$data.$private_key, 1));
        $postfields = http_build_query(array(
            'data' => $data,
            'signature' => $signature
        ));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$postfields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        $server_output = curl_exec($ch);
        curl_close($ch);
        $g_data =  json_decode($server_output);

//        try {
//            $g_data = json_decode(file_get_contents("php://input"), true);;
//        } catch (Exception $ex) {
//            $g_data = null;
//        }

        if (empty($g_data)) { $g_data = request()->all();}

        //пришёл любой запрос, пишем его в лог файл на сервер
        Log::info('---WayForPayController@Api----------------------------------------------------- ', [request()->all()]);


//        $vfr = $this->verufyFailApiSignature($g_data);
//        if ($vfr) {                                                             //ОШИБКА
//            Log::warning('---WayForPayController@Api---> '.$vfr);               //пишем в лог
//            Log::warning('---WayForPayController@Api---> '.request());           //пишем в лог *TODO delete
//            return response($vfr, 403);}                                        //посылем серверу ответ

        $statusTA =   trim($g_data['status'])?mb_strtolower(trim($g_data['status'])):'';

        if(in_array($statusTA,  $this->aliasPendingTrans)) { return $this->sendOkWFP($g_data['order_id']); }

        $balance_id = (int)$g_data['order_id'];
        $summa      = (int)$g_data['amount'];
        $currency   = $g_data['currency'];
        $status     = ($statusTA == 'success') ? TRUE : FALSE;

        $balance = Balance::find($balance_id);
        if (!$balance) {
            Log::warning('WayForPayController@Api, нет записи в истории баланса ------------------------- '); return response('unknow orderReference', 403);
        }

        if ($balance->summa != $summa) {
            Log::warning('WayForPayController@Api, не совпадает сумма платежа ------------------------- '); return response('unknow amount', 403);
        }

        if ($balance->currency->code != $currency) {
            Log::warning('WayForPayController@Api, не совпадает валюта платежа ------------------------- '); return response('unknow currency', 403);
        }

        if ( $balance->status_id != 1 ) { return $this->sendOkWFP($g_data['order_id']); }//эта операцию уже подтверждена раньше

        $this->updateBalanceAndOrder(request(),$balance, $statusTA, $status);


        return $this->sendOkWFP($g_data['order_id']);
    }
    protected function updateBalanceAndOrder(Request $request, Balance $balance, $statusTA, $status = TRUE) {
        if ($status === TRUE) {
            //$this->approvedBalance($balance);//approved
            dispatch(new ApprovedBalance($balance,TRUE));

        } else {
            //$this->rejectedBalance($balance);//rejected
            dispatch(new RejectedBalance($balance));
        }

//        try {
//            $trans = new BalanceTransactions([
//                'api'       => 'WayForPay',
//                'code'      => $statusTA,
//                'history'   => $request->all()
//            ]);
//            $balance->transaction()->save($trans);
//        } catch (Exception $ex) {
//            return ;
//        }
    }

    protected function approvedBalance(Balance $balance){
        $balance->status_id = 3;//approved
        $balance->save();
        $order = $balance->order;
        if (!$order) { return;}//простое пополнение
        //
        //создать встречную запис и перепривязать ордер
        $order->update(['balance_id'=>null]);//отвязали

        $userbalance = $this->createApprovedBalance($order, 3);

        return $userbalance;
    }

    protected function createApprovedBalance(Order $order, $status_id = 3) {
        $opreation_type = $order->gift?4:3; //4 with gift, 3 donate;

        $userbalance =  Balance::create([
            'summa'             => -$order->summa,
            'user_id'           => $order->user_id,
            'currency_id'       => 1, //UAH
            'operation_type_id' => $opreation_type,
            'status_id'         => $status_id,
        ]);

        $this->updateApprovedOrder($order, $userbalance);
        BalanceProjects::create(['balance_id'    => $userbalance->id,'project_id'    => $order->project_id ]);
        return $userbalance;
    }

    protected function updateApprovedOrder(Order $order, Balance $balance) {
        $order->update(['balance_id'=>$balance->id,'status_id'=>$balance->status_id]);
        if (!$order->gift) { return;}//без подарков

        try {
            $order->usergifts->update(['balance_id'=>$balance->id]);
        } catch (Exception $ex) {
            return ;
        }

    }


    protected function sendOkWFP($orderReference)
    {
        //$orderReference = $request->input('orderReference');

        $data = [
            "order_id"    => $orderReference,
            "status"            => "accept",
            "time"              => Carbon::createFromTimestampUTC(time())->timestamp,
        ];

//        $data['signature'] = hash_hmac('md5', implode(self::FIELDS_DELIMITER, $data), $this->_merchant_password);

        return $data;
    }
//    protected function verufyFailApiSignature($g_data) {
//        $vfaf = $this->verifyFailApiFields($g_data);
//        if ($vfaf) { return $vfaf;}
//
//        $sign = $this->createForApiSignature($g_data);
//
//        if(empty($g_data['merchantSignature'])) {
//            return 'Empty signature in request';
//        }
//
//        return ($sign != $g_data['merchantSignature'])?'Bad signature in request':false;
//    }

/**
 * cnb_form
 *
 * @param array $params
 *
 * @return string
 *
 * @throws InvalidArgumentException
 */
    public function createFormBalance(Balance $balance, $text_to = '') {
        $micro = sprintf("%06d",(microtime(true) - floor(microtime(true))) * 1000000);
        $number = date("YmdHis"); //Все вместе будет первой частью номера ордера
        $order_id = $number.$micro; //Формирование номера ордера таким образом…

        $fields = [
            'version' => '3',
            'description' =>  $text_to,
//            'order_id' => $order_id,
            'result_url' => 'https://xn--80aalqhgr0a2d.xn--j1amh/ua', // перенаправление клиента на страницу 'result_url', после оплаты
            'server_url' => 'https://xn--80aalqhgr0a2d.xn--j1amh/storage/callback.php', // callback принимающий ответ от liqpay
            'order_id'    => (env('WFP_TEST','TRUE')=='TRUE')?'TM'.$balance->id:$balance->id,
            'orderDate'         => Carbon::createFromTimestampUTC($balance->created_at->timestamp)->timestamp,
            'amount'            => $balance->summa,
            'currency'          => 'UAH',
            'productName'       => $text_to?$text_to:'Запись №'.$balance->id,
            'productPrice'      => $balance->summa,
            'productCount'      => 1,
            'clientEmail'       => $balance->user->email
        ];

        return $this->cnb_form($fields);
    }

public function cnb_form($params)
{
    $language = 'ru';
    if (isset($params['language']) && $params['language'] == 'en') {
        $language = 'en';
    }
    $params = $this->cnb_params($params);
    $data = base64_encode( json_encode($params) );
    $signature = $this->cnb_signature($params);
    return sprintf('
        <form method="POST" action="%s" accept-charset="utf-8">
%s
%s
<input style="visibility: hidden" id="form_for_pay_ik_other" type="image" src="//static.liqpay.com/buttons/p1%s.radius.png" name="btn_text" />
</form>
',
$this->_checkout_url,
sprintf('<input type="hidden" name="%s" value="%s" />', 'data', $data),
sprintf('<input type="hidden" name="%s" value="%s" />', 'signature', $signature),
$language
);
}

/**
 * cnb_signature
 *
 * @param array $params
 *
 * @return string
 */
public function cnb_signature($params)
{
    $params = $this->cnb_params($params);
    $private_key = $this->_private_key;
    $json = base64_encode( json_encode($params) );
    $signature = $this->str_to_sign($private_key . $json . $private_key);
    return $signature;
}
/**
 * cnb_params
 *
 * @param array $params
 *
 * @return array $params
 */
private function cnb_params($params)
{
    $params['public_key'] = $this->_public_key;
    if (!isset($params['version'])) {
        throw new InvalidArgumentException('version is null');
}
    if (!isset($params['amount'])) {
        throw new InvalidArgumentException('amount is null');
}
    if (!isset($params['currency'])) {
        throw new InvalidArgumentException('currency is null');
}
    if (!in_array($params['currency'], $this->_supportedCurrencies)) {
        throw new InvalidArgumentException('currency is not supported');
}
    if ($params['currency'] == 'RUR') {
        $params['currency'] = 'RUB';
    }
    if (!isset($params['description'])) {
        throw new InvalidArgumentException('description is null');
}
    return $params;
}
/**
 * str_to_sign
 *
 * @param string $str
 *
 * @return string
 */
public function str_to_sign($str)
{
    $signature = base64_encode(sha1($str,1));
    return $signature;
}
}