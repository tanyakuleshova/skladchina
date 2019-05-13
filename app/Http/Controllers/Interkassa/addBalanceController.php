<?php

namespace App\Http\Controllers\Interkassa;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Billing\Balance;
use App\Models\Billing\BalanceTransactions;
use App\Models\Billing\BalanceProjects;
use App\Models\Billing\Order;

class addBalanceController extends Controller
{
    /**
     * Метод обработки ответа интеркассы, после проверки  контроллером Интеркассы.
     * @param Request $request
     * @return void
     */
    public function apiInterkassa(Request $request)
    {
        $balance_id = (int)$request->ik_pm_no;
        $summa      = (int)$request->ik_am;
        $currency   = $request->ik_cur;
        $status     = ($request->ik_inv_st == 'success') ? TRUE : FALSE;

        $balance = Balance::find($balance_id);
        if (!$balance) {
            Log::warning('BalanceController@apiInterkassa, нет записи в истории баланса ------------------------- ', [$request->all()]); return;
        }
        
        if ($balance->summa != $summa) {
            Log::warning('BalanceController@apiInterkassa, не совпадает сумма платежа ------------------------- ', [$request->all(),$balance->toArray()]); return;
        }
        
        if ($balance->currency->code != $currency) {
            Log::warning('BalanceController@apiInterkassa, не совпадает валюта платежа ------------------------- ', [$request->all(),$balance->toArray()]); return;
        }
        
        if ($balance->status_id === 3) { return; }//эта операцию уже подтверждена раньше
        
        $this->updateBalanceAndOrder($request,$balance, $status);
    }

    protected function updateBalanceAndOrder(Request $request, Balance $balance, $status = TRUE) {
        if ($status === TRUE) {
            $this->approvedBalance($balance);//approved
        } else {
            $this->rejectedBalance($balance);//rejected
        }

        try {
            $trans = new BalanceTransactions([
                'api'       => 'interkassa',
                'code'      => $request->ik_inv_st,
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
        $order->update('balance_id',null);//отвязали
        
        $userbalance = $this->createApprovedBalance($order, 3);
        
        return $userbalance;
    }
    
    protected function rejectedBalance(Balance $balance){
        $balance->status_id = 2;//rejected
        $balance->save();
        $order = $balance->order;
        if (!$order) { return;}//простое пополнение
        
        if (!$order->gift) { 
            $order->delete();
            return;}//без подарков
        
        if($order->usergifts) {
            $order->usergifts->delete();
        }
        $order->delete();
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
        $order->gift->update(['balance_id'=>$balance->id]);
    }
    
    
    
    public function intSuccess(Request $request)
    {
        return redirect(route('mybalance.index'))->with('success_message', $request->user()->name . ' Ваш платеж успешно проведен.');
    }

    public function intFail(Request $request)
    {
        return redirect(route('mybalance.index'))->with('warning_message', $request->user()->name . ' Ваш платеж отменен.');
    }

    public function intWaiting(Request $request)
    {
        return redirect(route('mybalance.index'))->with('warning_message', $request->user()->name . ' Ваш платеж не проведен статус - на ожидании.');
    }
}
