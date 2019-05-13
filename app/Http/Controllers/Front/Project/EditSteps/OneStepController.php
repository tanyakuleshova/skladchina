<?php

namespace App\Http\Controllers\Front\Project\EditSteps;

use App\Models\Project\Project;
use App\Models\SettingProject\CategoryProject;
use App\Models\SettingProject\StatusProject;
use App\Models\SettingProject\TypeProject;
use App\Models\SettingProject\City;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

//use Image;
use File;

use App\Jobs\ImageResizeRulesRatio;

class OneStepController extends Controller
{

    /**
     * Отображаем форму для редактирования, первого шага создания проекта
     *
     * @param  Project $project
     * @return \Illuminate\Http\Response
     */
    public static function edit(Project $project)
    {
        $city                   = City::with('lang')->get();
        $categories_project     = CategoryProject::with('lang')->get();
        $type_status_projects   = StatusProject::get();
        $type_project           = TypeProject::all();
        
        $first_start  = request()->cookie('first_start_'.$project->id,true);
        
        return response()->view('front.project.show_steps.edit_one', compact('project', 'categories_project', 'type_status_projects','city','type_project','first_start'))->cookie('first_start_'.$project->id,false,time()+ 24*30);
    }

    /**
     * Метод обновления, первого шага создания проекта
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Project $project
     * @return \Illuminate\Http\Response
     */
    public static function update(Request $request, Project $project)
    {
        $project->name          = strip_tags($request->input('project_name'));
        $project->short_desc    = strip_tags($request->input('short_descr'));
        
        $project->category_id   = $request->input('category_id');
        $project->city_id       = $request->input('city_id');
        $project->need_sum      = $request->input('need_sum');
        
        $project->type_id       = $request->input('type_status_id');
        $project->duration   = $request->input('duration',1);

            $project->poster_link = $request->file('poster_link')->storePublicly('project/'.$project->id,'public');
            dispatch(new ImageResizeRulesRatio(600, 400, $project->poster_link));
            //Image::make(Storage::disk('public')->path($project->poster_link))->widen(600)->resizeCanvas(600, 300)->save(Storage::disk('public')->path($project->poster_link))->destroy();
        
        
        $project->save();
        self::validateUpdate($project);
        return back()->with('success_message', 'Данные успешно обновлены');
    }
    
    protected static function validatePFile(Request $request) {
        $val = Validator::make($request->toArray(),[ 
                'poster_link'   =>'mimes:jpeg,bmp,png'
                ]);
        return $val->passes();
    }

    protected static function validateUpdate(Project $project) {
        $val = Validator::make($project->toArray(),[ 
                'name'          =>'required',
                'poster_link'   =>'required',
                'short_desc'    =>'required',
                'category_id'   =>'required',
                'city_id'       =>'required',
                'need_sum'      =>'required',
                'type_id'       =>'required',
                'duration'      =>'required_if:type_id,1']
                );
        if (!$project->valid_steps) { $project->valid_steps = array(); }

        $res = array_filter($project->valid_steps, function ($element) { return ($element != 1); } );
        
        if ($val->passes()) {
            $res[]=1;
        } 
        
        sort($res);
        $project->update(['valid_steps'=>$res]);
    }

}
