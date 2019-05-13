<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Models\Billing\PayMethod as PMethod;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PayMethod extends Controller
{

    public function __construct() {
        $this->middleware('auth:admin'); 
    }
    
    /**
     * Показать список доступных платёжных методов
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paymethods = PMethod::withoutGlobalScopes()->paginate(20);
        return view('admin.settings.paymethod.list', compact('paymethods'));
    }


    /**
     * Метод вывода представления редактирования платёжного метода
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $paymethod= PMethod::withoutGlobalScopes()->findOrFail($id);
        return view('admin.settings.paymethod.edit', compact('paymethod'));   //Возвращаем представление с данными для редактирования
    }


    /**
     * Метод обновления платёжного метода
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
        
        $status = PMethod::withoutGlobalScopes()->findOrFail($id);
        
        $status->update(['name'=>$request->input('name'),'active'=>$request->input('status', -1)]);

        return redirect()->route('paymethods.index')->with('success', 'Описание для "'.$status->name.'" успешно обноавлено!');
    }

}
