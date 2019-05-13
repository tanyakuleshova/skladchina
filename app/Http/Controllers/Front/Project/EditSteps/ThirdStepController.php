<?php

namespace App\Http\Controllers\Front\Project\EditSteps;

use App\Models\Project\Project;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Image;
use File;

class ThirdStepController extends Controller
{

    /**
     * Метод вывода формы третьего шага создания и редактирования проекта
     * @param Project $project
     * @return \Illuminate\Http\Response|\Illuminate\View\View
     */
    public static function edit(Project $project)
    {
        $project->update(['project_giftt_type' => 1]);//@TODO delete, fix old project no gift
        return view('front.project.show_steps.edit_third', compact('project'));
    }

    /**
     * Метод обновления, третьего шага создания проекта
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Project $project
     * @return \Illuminate\Http\Response
     */
    public static function update(Request $request, Project $project)
    {
        self::validateUpdate($project);
        return back()->with('success_message', 'Данные успешно обновлены');
    }
    

    public static function validateUpdate(Project $project) {
        //пересоздание массива правильно заполненных шагов
        if (!$project->valid_steps) { $project->valid_steps = array(); }
        $res = array_filter($project->valid_steps, function ($element) { return ($element != 3); } );

        if($project->projectGifts()->count()) {
            $res[]=3;//в любом случае - есть один подарок
        }
        
        sort($res);
        $project->update(['valid_steps'=>$res]);
    }

}
