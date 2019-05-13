<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Models\Project\Project;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AdminDeletedProject implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Project 
     */
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
        //реквизиты
        $this->project->requisites()->forceDelete();
        
        //видео
        $this->project->projectVideo()->forceDelete();
        
        //удаляем обновления  
        foreach ($this->project->pupdates as $pup) { $pup->forceDelete();}
        
        //удаляем комментарии  
        foreach ($this->project->comments as $com) { $com->forceDelete();} 
        
        //связь с балансом
        $this->project->balance()->detach();

        
        //ордера, скорее всего их уже нет
        foreach ($this->project->orders as $dat) { $dat->forceDelete();} 
        
        //подарки выбранные пользователями, скорее всего их уже нет
        foreach ($this->project->projectUserGifts as $dat) { $dat->forceDelete();} 
        
        //подарки проекта, скорее всего их уже нет
        //$this->project->projectGifts()->delete();
        foreach ($this->project->projectGifts as $dat) { $dat->forceDelete();} 
        
        Log::notice('Проект "'.$this->project->name.'", удалён навсегда, id='.$this->project->id);
        Storage::disk('public')->deleteDirectory('project/'.$this->project->id);
        
        $this->project->forceDelete();
        
    }
}
