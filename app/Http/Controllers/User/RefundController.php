<?php

namespace App\Http\Controllers\User;


use App\Models\Billing\Balance;

use App\Models\Account\UserDeclarationRefund;
use App\Models\Account\UserPayMethod;
use App\Models\Billing\PayMethod;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Storage;

class RefundController extends Controller
{
    public function __construct() {
        $this->middleware(['web','auth']); 
    }
    
    /**
     * Список операций по балансу
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $rlist = UserDeclarationRefund::where('user_id',$request->user()->id)
                ->latest()
                ->orderBy('status_id','desc')
                ->paginate(10);
        return view('front.user.refund.list', compact('rlist'));
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
    public function show(Request $request, $id)
    {
        $refund = UserDeclarationRefund::findOrFail($id);
        
        if ($refund->user_id !== $request->user()->id) { return back()->with('warning_message',' Где-то ошибочка '); }
        
        return view('front.user.refund.show', compact('refund'));
    }
    
    
}
