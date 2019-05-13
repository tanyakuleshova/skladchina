<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Models\Billing\BalanceStatus as Status;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BalanceStatus extends Controller
{

    public function __construct() {
        $this->middleware('auth:admin'); 
    }
    
    /**
     * Показать список статусов операций
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $statuses = Status::paginate(20);
        return view('admin.settings.balance.status_list', compact('statuses'));
    }


    /**
     * Метод вывода представления редактирования статусов операций
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $status = Status::findOrFail($id);
        return view('admin.settings.balance.status_edit', compact('status'));   //Возвращаем представление с данными для редактирования
    }


    /**
     * Метод обновления статусов операций
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required'
        ], [
            'name.required' => 'Описание обязательный параметр'
        ]);
        
        $status = Status::findOrFail($id);
        
        $status->update(['name'=>$request->input('name')]);

        return redirect()->route('balance_status.index')->with('success', 'Описание для "'.$status->name.'" успешно обноавлено!');
    }

}
