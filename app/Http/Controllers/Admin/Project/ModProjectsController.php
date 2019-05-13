<?php

namespace App\Http\Controllers\Admin\Project;

use App\Models\Project\Project;

use App\Jobs\ApprovedProjectJob;
use App\Jobs\NoModerationProjectJob;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Admin;
use App\User;

class ModProjectsController extends Controller
{
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::guard('admin')->user()->isAdmin) {
            $projects = Project::moderation()->orderBy('created_at','DESC')->get();
        } else {
            $projects = Project::moderation()->where('admin_id',Auth::guard('admin')->id())->orderBy('created_at','DESC')->get();
        }
        return view('admin.project.mod.list',compact('projects'));
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(Auth::guard('admin')->user()->isAdmin) {
            $project = Project::moderation()->find($id);
        } else {
            $project = Project::moderation()->where('admin_id',Auth::guard('admin')->id())->find($id);
        }

        if(!$project){ return back()->with('info','Проект не найден'); }
        
        if (Auth::guard('admin')->user()->id == 1) {
            $admins = Admin::all();
        } else {
            $admins = collect(Admin::find(Auth::guard('admin')->user()));
        }
        

        return view('admin.project.mod.show',compact('project','admins'));
    }
    
    /**
     * Display the specified resource.
     * @param Request $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
        if(Auth::guard('admin')->user()->isAdmin) {
            $project = Project::moderation()->find($id);
        } else {
            $project = Project::moderation()->where('admin_id',Auth::guard('admin')->id())->find($id);
        }
        
        //$project = Project::moderation()->find($id);
        if(!$project){ return back()->with('info','Проект не найден'); }
        
        $action     = $request->input('action');
        $location   = trim($request->input('location'));
        if (!$location || $location=='') { $location = 'Без объяснений!';}
        
        if($request->admin_id && Auth::guard('admin')->user()->isAdmin) {
            $project->update(['admin_id'=>$request->admin_id]);
        }
        

        switch ($action){
            case 'approved':
                if (!$project->duration && $project->type_id == 1) {
                    return back()->with('info','Для запуска проекта недостаточно времени !!!')->withInput();
                }
                dispatch(new ApprovedProjectJob($project));
                return redirect()->route('a_allprojects.index')->with('success','Проект '.$project->name.' прошел модерацию и доступен');
            case 'rejected':
                dispatch(new NoModerationProjectJob($project, $location));
                return redirect()->route('a_allprojects.index')->with('success','Вы отправили проект '.$project->name.' на доработку');
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
