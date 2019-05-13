<?php

namespace App\Http\Controllers\Front\Project\EditSteps;

use App\Models\Project\Project;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class FourStepController extends Controller
{

    /**
     * Отображаем форму для редактирования, четвёртого шага создания проекта
     *
     * @param  Project $project
     * @return \Illuminate\Http\Response
     */
    public static function edit(Project $project)
    {
        return view('front.project.show_steps.edit_four', compact('project'));
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
        $path = $request->user()->account->avatar_link;
        if ($request->hasFile('profile_avatar')) {
            if($path){
                Storage::disk('public')->delete($path);
            }
            $path = $request->file('profile_avatar')->storePublicly('users/'.$request->user()->id,'public');
        }
        
        $param = [
            'social_href_facebook'  => $request->input('sc_facebook'),
            'city_birth'            => $request->input('city_birth'),
            'user_site'             => $request->input('site'),
            'about_self'            => $request->input('about_self'),
            'avatar_link'           => $path ];
        
        if ($request->user()->account) {
            $request->user()->account()->update($param);
        } else {
            $request->user()->account()->create($param);
        } 
        

        self::validateUpdate($project, $request->user()->account()->first());
        return back()->with('success_message', 'Данные успешно обновлены');
    }

    protected static function validateUpdate(Project $project, $account) {
        $val = Validator::make($account->toArray(),[ 
            'social_href_facebook'  =>'required',
            'city_birth'            =>'required',
            'user_site'             =>'required',
            'about_self'            =>'required',
            'avatar_link'           =>'required',
            ] );

        if (!$project->valid_steps) { $project->valid_steps = array(); }

        $res = array_filter($project->valid_steps, function ($element) { return ($element != 4); } );

        if ($val->passes()) {
            $res[]=4;
        } 
       
        sort($res);
        $project->update(['valid_steps'=>$res]);
    }

}
