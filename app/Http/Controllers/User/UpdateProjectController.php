<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Models\Project\Project;
use App\Models\Project\ProjectUpdate;


class UpdateProjectController extends Controller
{
    public function __construct() {
        $this->middleware(['web','auth']); 
    }
    
    /**
    * Список
    * @param Request $request
    * @return \Illuminate\Http\Response
    */
    public function index(Request $request)
    {

        $project = Project::where('user_id',$request->user()->id)->find($request->input('project_id',0));
        if(!$project) { return back()->with('warning_message', 'Неизвестный проект'); }
        
        $updates = ProjectUpdate::where('project_id',$project->id)->paginate(15);
        
        return view('front.user.myproject.list_update',compact('project' , 'updates'));
    }

    /**
     * Форма 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $project = Project::where('user_id',$request->user()->id)->find($request->input('project_id',0));
        if(!$project) { return back()->with('warning_message', 'Неизвестный проект'); }
        
        return response()->view('front.user.myproject.create_update',['project'=>$project]);
    }
    
    /**
     * Метод создания новой записи
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request,[ 
                'project_id'=>'required',
                'shot_desc'=>'required',
                'main_desc'=>'required',]
                ,[
                'project_id.required'=>'Неизвестный проект.',
                'shot_desc.required'=>'Данное поле обязательное.',
                'main_desc.required'=>'Данное поле обязательное.',
                ]);
        
        $project = Project::where('user_id',$request->user()->id)->find($request->input('project_id',0));
        if(!$project) { return back()->with('warning_message', 'Неизвестный проект'); }
        
        $upd = new ProjectUpdate();
        if ($request->file('application_image')) { $upd->image = $request->file('application_image')->storePublicly('project/'.$project->id,'public');}
        $upd->shotDesc  = $request->input('shot_desc');
        $upd->text      = $request->input('main_desc');
        $upd->status_id = 1;
        $upd->user_id   = $request->user()->id;
        
        $project->pupdates()->save($upd);
        return redirect(route('projectup.index').'?project_id='.$project->id)->with('success_message','Обновление отправлено администратору на проверку.');
    }
    
    
    
    /**
     * Метод вывода представления просотра записи
     * @param Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $project = Project::where('user_id',$request->user()->id)->find($request->input('project_id',0));
        if(!$project) { return back()->with('warning_message', 'Неизвестный проект'); }
        
        $upd = ProjectUpdate::find($id);
        if(!$upd || $upd->project_id != $project->id) { return back()->with('warning_message', 'Неизвестное обновление'); }
        
        return response()->view('front.user.myproject.show_update',['project'=>$project,'upd'=>$upd]);
    }
    
    
    /**
     * Метод вывода представления просотра записи
     * @param Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */

    public function destroy(Request $request, $id)
    {
        $project = Project::where('user_id',$request->user()->id)->find($request->input('project_id',0));
        if(!$project) { return back()->with('warning_message', 'Неизвестный проект'); }
        
        $upd = ProjectUpdate::find($id);
        if(!$upd || $upd->project_id != $project->id) { return back()->with('warning_message', 'Неизвестное обновление'); }
        
        if($upd->isApproved)  { return back()->with('warning_message', 'Невозможно удалить проверенное обновление'); }
        
        $upd->delete();
        return redirect(route('projectup.index').'?project_id='.$project->id)->with('success_message','Обновление успешно удалено.');
    }
}
