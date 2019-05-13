<?php

namespace App\Http\Controllers\Admin\Project;

use App\Models\Project\Project;
use App\Models\SettingProject\CategoryProject;
use App\Models\SettingProject\City;
use App\Models\SettingProject\StatusProject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use File;
use Image;

class projectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::orderBy('created_at','DESC')->paginate(20);
        
        return view('admin.project.all.list',compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = Project::find($id);
        if(!$project){
            return back()->with('info','Проект не найден');
        }
        return view('admin.project.all.show',compact('project'));
    }

    /**
     * Метод вывода формы администратору сайта для редактирования проекта пользователей
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit($id)
    {
        $project = Project::find($id);
        if(!$project){
            return back()->with('info','Ошибка при поиске проекта');
        }
        $categories_project = CategoryProject::with('lang')->get();
        $type_status_projects = StatusProject::get();
        $cities     = City::with('lang')->get();        
        return view('admin.project.edit_project',compact(
            'project',
                'type_status_projects',
                'categories_project',
                'cities'));
    }

    /**
     * Метод удаления постера проекта
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deletePoster($id){
        $project = Project::find($id);
        if(!$project){
            return back()->with('warning','Проект не найден.');
        }
        if(file_exists(public_path($project->poster_link))){
            File::delete($project->poster_link);
        }
        $project->update([
            'poster_link'=>null
        ]);
        return back()->with('success','Постер проекта успешно удален!');
    }

    /**
     * Метод обновления информации проекта основной
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateInfoProjectOne(Request $request, $id)
    {
        $update_project = Project::find($id);
        if(!$update_project){
            return back()->with('warning','Проект не найден.');
        }
        $update_project->update([
            'name'=>$request->title,
            'category_id'=>$request->category_id,
            'city_id'=>$request->city_id,
            'project_status_id'=>$request->type_status_id,
            'need_sum'=>$request->need_sum,
            'current_sum'=>$request->current_sum,
            'short_desc'=>$request->short_desc,
            'description'=>$request->description,
        ]);
        if($request->location){
            $update_project->update([
               'location'=>$request->location
            ]);
        }
//        if($request->poster_link){
//            if(file_exists(public_path($update_project->poster_link))){
//                File::delete($update_project->poster_link);
//            }
//            $poster = $request->file('poster_link');
//            $hash_str = str_random(5);
//            $filename = 'project_' . $hash_str . '.' . $poster->getClientOriginalExtension();
//            Image::make($poster)->resize(600, 360)->save(public_path('images/project/' . $filename));
//            $update_project->poster_link = 'images/project/' . $filename;
//            $update_project->save();
//        }
        
        if ($request->hasFile('poster_link')) {
            if (file_exists(public_path($update_project->poster_link))) { File::delete($update_project->poster_link); }
            Storage::disk('public')->delete($update_project->poster_link);
            $update_project->poster_link = $request->file('poster_link')->storePublicly('project/'.$project->id,'public');
            //Image::make(Storage::disk('public')->path($project->poster_link))->resize(600, 360)->save(Storage::disk('public')->path($project->poster_link))->destroy();
        }
        
        
        
        if($request->date_finish){
            $update_project->update([
                'date_finish'=>$request->date_finish
            ]);
        }
       return back()->with('success','Проект успешно обновлен!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Метод вывода новых проектов отправленых на модерирование
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function newProject(){
        $projects =Project::where('mod_status',1)->orderBy('created_at','DESC')->get();
        return view('admin.project.new_list_projects',compact('projects'));
    }

    /**
     * Метод изменения статуса проекта
     * @param $status
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeModeStatus($status,$id){
            $project= Project::find($id);
            if(!$project){
                return back()->with('info','Возникла ошибка при изменения статуса проекта.');
            }
            $project->mod_status = $status;
            $project->save();
            if($status == 2){
                $message= 'Проект успешно активирован';
            }elseif ($status == 3){
                $message= 'Проект успешно закрыт';
            }else{
                $message= 'Проект успешно отправлен на редактирвоание';
            }
            return back()->with('success',$message);
    }
}
