<?php

namespace App\Http\Controllers\Front\Project\EditSteps;

use App\Models\Project\Project;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class FiveStepController extends Controller
{

    /**
     * Отображаем форму для редактирования, пятого шага создания проекта, реквизиты
     *
     * @param  Project $project
     * @return \Illuminate\Http\Response
     */
    public static function edit(Project $project)
    {
        return view('front.project.show_steps.edit_five', compact('project'));
    }

    /**
     * Метод обновления,  шага создания проекта
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Project $project
     * @return \Illuminate\Http\Response
     */
    public static function update(Request $request, Project $project)
    {
        return back()->with('success_message', 'Данные успешно обновлены');
    }

    public static function validateUpdate(Project $project, $ok = false) {

        if (!$project->valid_steps) { $project->valid_steps = array(); }
        $res = array_filter($project->valid_steps, function ($element) { return ($element != 5); } );
        if ($ok) { $res[]=5; } 
        sort($res);
        $project->update(['valid_steps'=>$res]);
    }

}
