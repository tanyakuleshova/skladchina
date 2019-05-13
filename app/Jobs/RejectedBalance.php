<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Models\Billing\Balance;
use Illuminate\Support\Facades\Log;

class RejectedBalance implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Balance 
     */
    protected $balance;
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Balance $balance)
    {
        $this->balance = $balance;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $order = $this->balance->order;
        $project = $this->balance->projects;
        
        $this->balance->status_id = 2;//rejected
        $this->balance->save();
        
        $this->balance->projects()->detach();
        
        if (!$order) { 
            Log::info('RejectedBalance --'.$this->balance->id.'-- no orders');
            return;
        
        }//простое пополнение

        
        if($order->usergifts) {
            Log::info('RejectedBalance --'.$this->balance->id.'-- usergift delete --'.$order->usergifts->id.'--');
            $order->usergifts()->delete();
        }
        Log::info('RejectedBalance --'.$this->balance->id.'-- order delete --'.$order->id.'--');
        
        $order->delete();
                
        //$project->update(['current_sum' => $project->getActualSumm()]);
    }
}
