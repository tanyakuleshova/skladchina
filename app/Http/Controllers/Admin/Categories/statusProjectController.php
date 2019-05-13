<?php

namespace App\Http\Controllers\Admin\Categories;

use App\Models\SettingProject\StatusProject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class statusProjectController extends Controller
{
    /**
     * Метод вывода представления списков статусов проектов
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $status_projects = StatusProject::get();
        return view('admin.project.settings.status_project_list', compact('status_projects'));
    }


    /**
     * Метод добавления нового статуса
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:4',
            'description' => 'required|min:30',
        ], [
            'name.min' => 'Минимальное допустимое название не меньше 4 букв.',
            'name.required' => 'Вы не заполнели поле название категории!',
            'description.required' => 'Вы не заполнили описание категории',
            'description.min' => 'Описание категории должно быть не меньше 30 символов.'
        ]);
        $new_stats = new StatusProject();
        $new_stats->name = $request->name;
        $new_stats->description = $request->description;
        $new_stats->save();
        return back()->with('success', 'Статус проектов успешно добавлен.');
    }

    /**
     * Метод обновления статуса проекта
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|min:4',
            'description' => 'required|min:30',
        ], [
            'name.min' => 'Минимальное допустимое название не меньше 4 букв.',
            'name.required' => 'Вы не заполнели поле название категории!',
            'description.required' => 'Вы не заполнили описание категории',
            'description.min' => 'Описание категории должно быть не меньше 30 символов.'
        ]);
        $status_project = StatusProject::find($id);
        $status_project->update([
            'name' => $request->name,
            'description' => $request->description
        ]);
        return back()->with('success','Статус проекта усешно обновлен.');
    }

    /**
     * Метод удаления статуса проекта
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $status_project = StatusProject::find($id);
        if(!$status_project){
            return back()->with('info','Статус проекта не найден.');
        }
        $status_project->delete();
        return back()->with('success','Статус успешно удален!');
    }
}
