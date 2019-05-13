<?php

namespace App\Http\Controllers\Admin\Project;

use App\Models\Project\Project;

use App\Models\SettingProject\CategoryProject;
use App\Models\SettingProject\City;
use App\Models\SettingProject\StatusProject;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use App\Admin;
use App\Jobs\AdminDeletedProject;

class AllProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::guard('admin')->user()->isAdmin) {
            $projects = Project::orderBy('created_at','DESC')->get();
        } else {
            $projects = Project::where('admin_id',Auth::guard('admin')->id())->orderBy('created_at','DESC')->get();
        }
        
        return view('admin.project.all.list',compact('projects'));
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
            $project = Project::find($id);
        } else {
            $project = Project::where('admin_id',Auth::guard('admin')->id())->find($id);
        }
        
        if(!$project){ return back()->with('info','Проект не найден'); }
        
        if (Auth::guard('admin')->user()->id == 1) {
            $admins = Admin::all();
        } else {
            $admins = collect(Admin::find($project->admin));
        }

        return view('admin.project.all.show',compact('project','admins'));
    }
    
    
    
    public function update(Request $request, $id)
    {
        if(Auth::guard('admin')->user()->isAdmin) {
            $project = Project::find($id);
        } else {
            $project = Project::where('admin_id',Auth::guard('admin')->id())->find($id);
        }
        
        if(!$project){ return back()->with('info','Проект не найден'); }

        if($request->admin_id && Auth::guard('admin')->user()->isAdmin) {
            $project->update(['admin_id'=>$request->admin_id]);
        }
        
        if($request->get('level_project')) {
            Project::where('id','>',0)->update(['level_project'=>0]);
            $project->update(['level_project'=>1]);
        } else {
            $project->update(['level_project'=>0]);
        }

        return redirect()->route('a_allprojects.index')->with('success','Вы изменили проект '.$project->name);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::guard('admin')->user()->isAdmin) {
            $project = Project::find($id);
        } else {
            $project = Project::where('admin_id',Auth::guard('admin')->id())->find($id);
        }
        //$project = Project::find($id);
        if(!$project){ return back()->with('info','Проект не найден'); }
        
        if($project->isActive) { return back()->with('info','Активный проект, нельзя удалить'); }
        if($project->isClosedSuccess) { return back()->with('info','Успешный проект, нельзя удалить'); }
        $name= $project->name;
        
        dispatch(new AdminDeletedProject($project));
        return back()->with('info','Проект "'.$name.'" успешно удалён!');
    }
}
