<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Models\Project\Project;
use App\Models\Billing\Order;
use App\Models\Billing\Orderfail;
use Illuminate\Support\Facades\Log;

class CloseProjectFail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $project;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Project $project)
    {
        $this->project  = $project;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
       
        foreach ($this->project->orders()->orderBy('created_at')->get() as $order) {
            $this->cloneOrederTo($order);
        }
        
        foreach ($this->project->balance as $balans) {
            $balans->operation_type_id = 7;
            $balans->status_id = 2;
            $balans->save();
            $balans->usergifts()->delete();
            $balans->order()->delete();
        }
        $this->project->orders()->delete();
        $this->project->update(['status_id' => 50]);
        Log::warning('Проект НЕУСПЕШНЫЙ'.$this->project->name);
    }
    
    /**
     * Клонирование ордера
     * @param Order $old
     * @return Orderfail
     */
    protected function cloneOrederTo(Order $old) {
        if ($old->balance && $old->isApproved) {
            $fo = new Orderfail();
            $fo->user_id        = $old->user_id;
            $fo->project_id     = $old->project_id;
            $fo->project_gift_id= $old->project_gift_id;
            $fo->quantity       = $old->quantity;
            $fo->summa          = $old->summa;
            $fo->balance_id     = $old->balance_id;
            $fo->userfields     = $old->userfields;
            $fo->history        = $old->history;
            $fo->save();
            $fo->save();
        }
    }
}
