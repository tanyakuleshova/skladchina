<?php

namespace App\Http\Controllers\Admin\Balance;

use App\Models\Billing;
use App\Models\Billing\Balance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Jobs\RejectedBalance;

class BalanceController extends Controller
{
    public function __construct() {
        $this->middleware('auth:admin'); 
    }
    
    /**
     * Список операций по балансу
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Balance $balance)
    {
        $balancies = Billing\Balance::latest()->get();
        return view('admin.balance.balance_list', compact('balancies'));
    }


    
    /**
     * Метод создания новой записи в баланс
     * @todo этот метод нужно ещё реализовать
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

    }
    
    /**
     * Метод вывода представления просотра записи в балансе
     * @todo этот метод нужно ещё реализовать
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $balance = Billing\Balance::findOrFail($id);
        abort(567, 'BalanceController.show');
    }

    /**
     * Метод обновления записи в балансе
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $balance = Billing\Balance::find($id);
        
        if(!$balance) { return redirect()->back()->with('info','Запись не найдена!'); }
        
        if ($balance->isApproved) { return redirect()->back()->with('info','Подтверждённую запись, невозможно изменить'); }
        
        if ($balance->isRejected) { 
            $admin = $balance->admin?(', администратором '.$balance->admin->name):'';
            return redirect()->back()->with('info','Запись отменена ранее'.$admin); }
        
        $balance->update(['admin_id'=>$request->user('admin')->id]);
            
        switch ($request->input('action')) {
            case 'rejected':
               dispatch(new RejectedBalance($balance));
               return redirect()->back()->with('success','Для записи успешно присвоен статус ОТМЕНА.');
            default:
                break;
        }    
            
//        $balance->admin_id  =  $request->user('admin')->id;
//        $balance->status_id = 2;//rejected
//        $balance->save();
        
        return redirect()->back()->with('info','Не известная команда.');
    }

    
    
}
