<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Models\Project\Project;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ApprovedProjectJob implements ShouldQueue
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
        Log::info('Project "'.$this->project->name.'" approved !!!');
        $this->project->status_id   = 30;
        $this->project->date_start  = Carbon::today();
        if($this->project->type_id == 1) {
            $this->project->date_finish = Carbon::today()->addDay($this->project->duration);

            foreach ($this->project->projectGifts as $gift){
                if($gift->delivery_id != 10) {
                    $gift->delivery_date = Carbon::today()->addDay($this->project->duration + $gift->duration);
                    $gift->save();
                }
            }

            
        }

        $this->project->save();
       
    }
}
