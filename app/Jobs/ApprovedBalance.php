<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Models\Billing\Balance;
use App\Models\Billing\BalanceProjects;
use App\Models\Billing\Order;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderSupportProjectMail;
use Exception;

class ApprovedBalance implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $balance;
    
    protected $sm;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Balance $balance, $send_mail = FALSE)
    {
        $this->balance  = $balance;
        $this->sm       = $send_mail;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->balance->status_id = 3;//approved
        $this->balance->save();
        $order = $this->balance->order;

        if (!$order) { return;}//простое пополнение
        // 
        //создать встречную запис и перепривязать ордер
        $order->update(['balance_id'=>null]);//отвязали
        $this->createApprovedBalance($order, 3);
        $this->send_mail($order);
    }
    

    /**
     * Отправить письмо
     * @param Order $order
     */
    protected function send_mail(Order $order){
        Log::info('Отправляем письмо, за поддержку по ордеру №'.$order->id);

        try {
            Mail::send(new OrderSupportProjectMail($order));
            Log::info('успешно');
        } catch (Exception $ex) {
            Log::error('ошибка отправки письма '.$ex->getMessage());
        } 
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
        $order->project()->update(['current_sum' => $order->project->getActualSumm()]);
        return $userbalance;
    }
    
    protected function updateApprovedOrder(Order $order, Balance $balance) {
        $order->update(['balance_id'=>$balance->id,'status_id'=>$balance->status_id]);
        if (!$order->gift) { return;}//без подарков
        
        try {
            $order->usergifts()->update(['balance_id'=>$balance->id]);
        } catch (Exception $ex) {
            Log::error('ошибка обновления статуса подарка '.$ex->getMessage());
            return ;
        } 
        
    }
    
}
