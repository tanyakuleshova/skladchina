<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Models\Billing\BalanceOperations;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BalanceType extends Controller
{

    public function __construct() {
        $this->middleware('auth:admin'); 
    }
    
    /**
     * Показать список всех типов операций баланса с пагинацией
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $types = BalanceOperations::paginate(20);
        return view('admin.settings.balance.type_list', compact('types'));
    }


    /**
     * Метод вывода представления редактирования типа операции баланса
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $type = BalanceOperations::findOrFail($id);
        return view('admin.settings.balance.type_edit', compact('type'));        //Возвращаем представление с данными для редактирования
    }


    /**
     * Метод обновления типа операции баланса
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
        
        $type = BalanceOperations::findOrFail($id);
        
        $type->update(['name'=>$request->input('name')]);

        return redirect()->route('balance_type.index')->with('success', 'Описание для "'.$type->name.'" успешно обноавлено!');
        
    }

}
