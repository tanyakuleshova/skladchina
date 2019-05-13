<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Project\Project;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

use App\Jobs\CloseProjectFail;
use App\Jobs\CloseProjectSuccess;
use App\Jobs\CloseProjectToModeration;

class AutoCloseProject extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'AutoCloseProject';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'AutoCloseProject from time';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('AutoCloseProject start check all approved project to end of time today ');
        Log::info('AutoCloseProject start check all approved project to end of time today ');
        
        //обработка универсальных проектов
        $projects_uni = Project::active()->whereNotNull('date_start')->whereDate('date_finish','<=',  Carbon::today())->get();
        foreach ($projects_uni as $project) {
            $this->warn('Project... id = ['.$project->id.'], name="'.$project->name.'"');
            Log::warning('Project... id = ['.$project->id.'], name="'.$project->name.'"');
            
            $this->autoCloseUniProject($project);
        }
        
        //обработка бессрочных проектов
        $projects_type_2 = Project::active()->whereNotNull('date_start')->whereNull('date_finish')->where('type_id',2)->get();
        foreach ($projects_type_2 as $project) {
            $this->warn('Project... id = ['.$project->id.'], name="'.$project->name.'"');
            Log::warning('Project... id = ['.$project->id.'], name="'.$project->name.'"');
            
            $this->autoCloseT2Project($project);
        }
    }
    
    /**
     * Закрытие УНИВЕРСАЛЬНОГО проекта по наступлению конечной даты
     * @param Project $project
     * @return void
     */
    protected function autoCloseUniProject(Project $project) {
        
        //$balance    = $project->getActualSumm();
        $procent    = $project->projectProcent();
        
        $project->update(['current_sum' => $project->getActualSumm()]);
        
        if ($procent <= 50)                     { dispatch(new CloseProjectFail($project)); }
        if ($procent > 50 && $procent < 100)    { dispatch(new CloseProjectToModeration($project)); }
        if ($procent >= 100)                    { dispatch(new CloseProjectSuccess($project)); }
    }
    
    /**
     * Закрытие БЕССРОЧНОГО проекта по наступлению условий
     * @param Project $project
     * @return void
     */
    protected function autoCloseT2Project(Project $project) {
        
        $balance    = $project->getActualSumm();
        $procent    = $project->projectProcent();
        
        $project->update(['current_sum' => $balance]);
        
        if ($procent >= 100)                    { dispatch(new CloseProjectSuccess($project)); }
        
        
//        if ($procent <= 50)                     { dispatch(new CloseProjectFail($project)); }
//        if ($procent > 50 && $procent < 100)    { dispatch(new CloseProjectToModeration($project)); }
//        $project = Project::with(['balance'=>function($query){
//                        return $query->where('user_id',request()->user()->id)->approved();
//                    }])->with(['projectUserGifts'=>function($query){
//                        return $query->where('user_id',request()->user()->id);
//                    }])->whereHas('balance')->find($id);
//->whereDate('created_at','=',$start_control)->whereDate('created_at','=',$end_control)
        
        $start_control  = Carbon::today()->subMonth();
        
        if ($project->date_start >= $start_control) { return; }                 //месяц не прошел

        
        $end_control    = Carbon::today()->addDay();
        $summa          = abs($project->balance()->whereBetween('balance.created_at',[$start_control,$end_control])->sum('summa'));
        
        
        $procent2    = $project->need_sum?$summa/$project->need_sum:0;
//        
//        
//        
//        dump('start',$start_control);
//        dump('end',$end_control);
//        dump('summa',$summa);
//        dump('proc',$procent2);
        
        if($procent2 < 5 ) { dispatch(new CloseProjectFail($project)); }
        
    }
}
