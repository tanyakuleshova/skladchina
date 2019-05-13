<?php

namespace App\Http\Controllers\Front\Project\EditSteps;

use App\Models\Project\Project;
use App\Models\Project\VideoProject;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

use Image;
use File;

class TwoStepController extends Controller
{

    /**
     * Отображаем форму для редактирования, второго шага создания проекта
     *
     * @param  Project $project
     * @return \Illuminate\Http\Response
     */
    public static function edit(Project $project)
    {
        return view('front.project.show_steps.edit_two', compact('project'));
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
        if ($request->video_iframe) {
            preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $request->video_iframe, $match);
            $project_video = new VideoProject();
            $project_video->project_id = $project->id;
            if (isset($match[1])) {
                $video_id = $match[1];
                $project_video->link_video = $video_id;
            } else {
                return back()->with('error_message', 'Невалидная ссылка')->withInput();
            }
            $project_video->self_video = 0;
            $project_video->save();
        }
        if ($request->file('video_user')) {
            $res = validator($request->all(),['video_user'=>'mimes:mp4,mov,ogg|max:500000' ],
                [ 'video_user.max'=>'Видео сильно много весит.','video_user.mimes'=>'Допустимы следующие типы видео :mp4,mov,ogg.']);
            if ($res->fails()) {return back()->with('error_message', $res->getMessageBag()->first('video_user'));}
            
            $project_video = new VideoProject();
            $project_video->project_id = $project->id;
            $project_video->self_video = 1;
            $project_video->link_video = $request->file('video_user')->storePublicly('project/'.$project->id.'/video','public');
            
            $project_video->save();
        }

        $project->description = $request->input('description');
        $project->save();

        self::validateUpdate($project);
        return back()->with('success_message', 'Данные успешно обновлены');
    }

    protected static function validateUpdate(Project $project) {
        $val = Validator::make($project->toArray(),[ 'description'   =>'required'] );

        if (!$project->valid_steps) { $project->valid_steps = array(); }

        $res = array_filter($project->valid_steps, function ($element) { return ($element != 2); } );

        if ($val->passes() && $project->projectVideo()) {
            $res[]=2;
        } 
        
        sort($res);
        $project->update(['valid_steps'=>$res]);
    }

}
