<?php

namespace App\Http\Controllers\Admin\Project;

use App\Models\Project\Project;

use App\Jobs\CloseProjectSuccess;
use App\Jobs\CloseProjectFail;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Admin;
use App\User;

class PostProjectsController extends Controller
{
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('onlyadmin');
    }
    
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::closedFMod()->orderBy('created_at','DESC')->get();

        return view('admin.project.postm.list',compact('projects'));
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $project = Project::closedFMod()->find($id);

        if(!$project){ return back()->with('info','Проект не найден'); }

        

        return view('admin.project.postm.show',compact('project'));
    }
    
    /**
     * Display the specified resource.
     * @param Request $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {            
        $project = Project::closedFMod()->find($id);
        if(!$project){ return back()->with('info','Проект не найден'); }


        switch ($request->input('action')){
            case 'continue':
                $days = $request->input('days',0);
                if (!$days) { return back()->with('info','Не возможно продлить проект "'.$project->name.'" на 0 дней'); }
                
                $project->date_finish=  Carbon::today()->addDay($days);
                $project->status_id=30;
                $project->save();
                return redirect()->route('a_allprojects.index')->with('success','Проект "'.$project->name.'" продлён на '.$days.' дней');
                
            case 'closesuccess':
                if ($project->projectProcent()<70) { return back()->with('info','Не возможно успешно закрыть проект "'.$project->name.'"'); }
                dispatch(new CloseProjectSuccess($project));
                return redirect()->route('a_allprojects.index')->with('success','Вы закрыли проект "'.$project->name.'" УСПЕШНЫМ !!!');
                
            case 'closedfail':
                dispatch(new CloseProjectFail($project));
                return redirect()->route('a_allprojects.index')->with('success','Вы закрыли проект "'.$project->name.'" ПРОВАЛОМ !!!');
        }
        return back()->with('error','Неизвестная комманда, сообщите администратору')->withInput();
    }
    
    
    /**
     * Метод авторизации под юзером и переходом на проект который нужно редактировать
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function inUserProject(Request $request, $id) {
        $project = Project::find($id);
        if(!$project){ return back()->with('info','Проект не найден'); }
        $user = $project->author;
        
        //Auth::guard('web')->logout();
        Auth::guard('web')->login($user);
        
        return redirect()->route('edit_project',$project->id);
        
    }

    
}
