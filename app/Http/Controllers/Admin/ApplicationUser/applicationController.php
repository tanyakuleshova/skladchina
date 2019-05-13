<?php

namespace App\Http\Controllers\Admin\ApplicationUser;

use App\Models\Application\ApplicationGetMoney;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class applicationController extends Controller
{
    /**
     * Метод вывода списка заявок пользователей на вывод денег
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $applications = ApplicationGetMoney::orderBy('status', 'DESC')->get();
        return view('admin.application.applications_list', compact('applications'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $application =  ApplicationGetMoney::find($id);
        $application->status = 1;
        $application->save();
        return view('admin.application.show_details', compact('application'));
    }

    /**
     * Метод удаления завки пользователя на снятие
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $application = ApplicationGetMoney::find($id);
        if (!$application) {
            return back()->with('info', 'Заявка не найдена!');
        }
//        $application->delete();
        return back()->with('success', 'Заявка успешно удалена!');
    }
}
