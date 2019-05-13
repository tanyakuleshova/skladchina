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

class NoModerationProjectJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $project;
    protected $location;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Project $project, $location)
    {
        $this->project   = $project;
        $this->location  = '['.Carbon::now()->toDateTimeString().'] - '.$location;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info('Project "'.$this->project->name.'" no moderation, return to edit with("'.$this->location.'")!!!');
        $this->project->location    = $this->location;
        $this->project->status_id   = 20;
        $this->project->save();
    }
}
