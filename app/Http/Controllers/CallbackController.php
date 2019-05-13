<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Wayforpay;
use Illuminate\Http\Request;

use App\Models\Billing\Balance;
use App\Models\Billing\BalanceTransactions;
use App\Models\Billing\BalanceProjects;
use App\Models\Billing\Order;

use App\Jobs\RejectedBalance;
use App\Jobs\ApprovedBalance;

class CallbackController extends Controller
{
    protected function tokensMatch(Request $request)
    {
        $token = $request->input('_token') ?: $request->header('X-CSRF-TOKEN');
        if ( ! $token && $header = $request->header('X-XSRF-TOKEN'))
        {
            $token = $this->encrypter->decrypt($header);
        }
        return StringUtils::equals($request->session()->token(), $token);
    }

public function index()
    {

            $signature = $_POST['signature'];
            $data = base64_decode($_POST['data']);
            $param = json_decode($data, true);
            $statusTA =   trim($param['status'])?mb_strtolower(trim($param['status'])):'';
            $balance_id = (int)$param['order_id'];
            $summa      = (int)$param['amount'];
            $currency   = $param['currency'];
            $status     = ($statusTA == 'wait_accept') ? TRUE : FALSE;

            $private_key = config('app.private_key');

            //Формируем подпись с нашим ключем
            $sign=base64_encode( sha1($private_key.$_POST['data'].$private_key, 1));

            //Сравниваем подпись с полученной
            if($sign == $signature){
                echo 'OK';
                $balance = Balance::find($balance_id);
                $this->updateBalanceAndOrder(request(),$balance, $statusTA, $status);
            }
        }

    protected function updateBalanceAndOrder(Request $request, Balance $balance, $statusTA, $status = TRUE) {
        if ($status === TRUE) {
            //$this->approvedBalance($balance);//approved
            dispatch(new ApprovedBalance($balance,TRUE));

        } else {
            //$this->rejectedBalance($balance);//rejected
            dispatch(new RejectedBalance($balance));
        }

        try {
            $trans = new BalanceTransactions([
                'api'       => 'WayForPay',
                'code'      => $statusTA,
                'history'   => $request->all()
            ]);
            $balance->transaction()->save($trans);
        } catch (Exception $ex) {
            return ;
        }
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


}
