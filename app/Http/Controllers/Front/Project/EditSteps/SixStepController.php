<?php

namespace App\Http\Controllers\Front\Project\EditSteps;

use App\Models\Project\Project;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SixStepController extends Controller
{

    static protected $StepsApprovedProject = [1,2,3,4,5];
    
    /**
     * Отображаем форму для редактирования, шестой шаг - отправка проекта на модерацию
     *
     * @param  Project $project
     * @return \Illuminate\Http\Response
     */
    public static function edit(Project $project)
    {
        $diff_steps = count(array_diff(self::$StepsApprovedProject,$project->valid_steps));
        return view('front.project.show_steps.edit_six', ['project'=>$project, 'diff_steps'=>$diff_steps]);
    }

    /**
     * Метод обновления, проверка и отправка на модерацию
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public static function update(Project $project)
    {
        $diff_steps = count(array_diff(self::$StepsApprovedProject,$project->valid_steps));
        
        if($diff_steps) { return back()->with('warning_message', 'Не все обязательные условия выполненны'); }
        
        $project->update(['status_id'=>10 ]);                //статус отправлен на модерацию
        
        return redirect(route('myprojects.index'))->with('success_message', 'Проект успешно отправлен на модерацию!');
    }

}
