<?php

namespace App\Http\Controllers\Admin\Users;


use App\Models\Billing\Balance;

use App\Models\Account\UserDeclarationRefund;
use App\Models\Account\UserPayMethod;
use App\Models\Billing\PayMethod;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class refundController extends Controller
{
    
    /**
     * Список операций на возврат средств
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rlist = UserDeclarationRefund::latest()->get();
        return view('admin.refund.list', compact('rlist'));
    }


    /**
     * Форма для пополнения баланса
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $listpm = PayMethod::all();
        return view('front.user.refund.create', compact('listpm'));
    }
    
    /**
     * Метод создания новой записи в историю баланса, в ответ выдается форма для Интеркассы
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
       
        $this->validate($request,[
            'application_image' =>'required|image',
            'summa'             =>'required|min:2',
            'paymethod'         =>'required',
            'number'            =>'required',
        ],[
            'required'          =>'Данні поля обов\'язкові',
            'money_sum.min'     =>'Сумма надто мала.'
        ]);
        
        $listpm = PayMethod::all()->pluck('id')->toArray();
        if (!in_array($request->input('paymethod'),$listpm)) { return back()->with('warning_message','Неизвестный платёжный метод')->withInput();}
        
        $balance = Balance::where('user_id',$request->user()->id)->approved()->sum('summa');
        $summa   = $request->input('summa');
        if ($summa>$balance) { return back()->with('warning_message','Доступно только '.$balance)->withInput();}
        
        ////////
        $pm = new UserPayMethod();
        $pm->user_id            = $request->user()->id;
        $pm->pay_method_id      = $request->input('paymethod');
        $pm->code               = $request->input('number');
        $pm->temp_name          = PayMethod::find($request->input('paymethod'))->name;
        $pm->save();
        
        ////////
        $refund = new UserDeclarationRefund();
        $refund->user_id                = $request->user()->id;
        $refund->currency_id            = 1;//UAH
        $refund->summa                  = $request->input('summa');
        $refund->status_id              = 1;//pending
        $refund->user_pay_methods_id    = $pm->id;
        $refund->user_declaration_image = Storage::disk('public')->putFile('refund/'.$request->user()->id, $request->file('application_image'));
        $refund->status_id              = 1;//pending
        $refund->status_id              = 1;//pending
        $refund->save();
        
        return redirect()->route('refund.index')->with('success_message','Ваша заявка отправлена на расмотрение.');
        
        
    }
    
    /**
     * Метод вывода представления просотра записи
     * @param Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $refund = UserDeclarationRefund::findOrFail($id);
        if(!$refund){ return back()->with('info','Заявка не найдена'); }
        return view('admin.refund.show', compact('refund'));
    }
    
    
    /**
     * Обновление статуса заявки на вывод средств
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        
        $refund = UserDeclarationRefund::pending()->find($id);
        if(!$refund){ return back()->with('info','Выплаты, в статусе ожидание не найдено'); }
        
        $action         = trim($request->input('action'));
        $admin_text     = trim($request->input('admin_text'))?:null;
        
        switch ($action){
            case 'approved':
                if(!$refund->user->checkmybalance($refund->summa)) { return back()->with('warning','Выплата '.$refund->user->fullName.' невозможна, не достаточно средств'); }
                $userbalance =  Balance::create([
                    'summa'             => -abs($refund->summa),
                    'user_id'           => $refund->user_id,
                    'admin_id'      => Auth::guard('admin')->id(),
                    'currency_id'       => 1, //UAH
                    'operation_type_id' => 5, //reversupay
                    'status_id'         => 3, 
                ]);
                $refund->update([
                    'admin_id'      => Auth::guard('admin')->id(), 
                    'status_id'     =>3, 
                    'admin_text'    =>$admin_text,
                    'balance_id'    =>$userbalance->id
                        ]);
                return redirect()->route('a_updates.index')->with('success','Выплата '.$refund->user->fullName.' зафиксирована');
            case 'rejected':
                $refund->update(['admin_id'=> Auth::guard('admin')->id(), 'status_id'=>2, 'admin_text'=>$admin_text]);
                return redirect()->route('a_updates.index')->with('success','Выплата '.$refund->user->fullName.' заблокирована');
        }
        return back()->with('error','Неизвестная комманда, сообщите администратору')->withInput();
        
    }
}
