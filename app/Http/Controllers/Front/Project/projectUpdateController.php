<?php

namespace App\Http\Controllers\Front\Project;


use App\Models\Project\Project;
use App\Models\Project\ProjectUpdate;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\Wayforpay\LiqpayController;

class projectUpdateController extends Controller
{
    public function __construct() {
        $this->middleware(['web','auth']); 
    }
    
    /**
     * Список обновлений
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        
        $balancies = Billing\Balance::where('user_id',$request->user()->id)
                ->latest()
                ->paginate(10);
        return view('front.user.balance.balance_list', compact('balancies'));
    }


    /**
     * Форма для пополнения баланса
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->view('front.user.balance.form_add_balance');
    }
    
    /**
     * Метод создания новой записи в историю баланса, в ответ выдается форма для Интеркассы
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $summa = (int)$request->input('summa', 0);
        if ($summa <= 0) { return response()->json (['errors'=>'некорректная сумма']); }

        $balance = new Billing\Balance([
            'summa'             => abs($summa),
            'user_id'           => $request->user()->id,
            'currency_id'       => 1, //UAH
            'operation_type_id' => 2, //addApi
            'status_id'         => 1, //pending
            ]);
        $balance->save();

//        $default = collect([
//            'ik_pm_no'  => $balance->id,
//            'ik_am'     => $balance->summa,
//            'ik_cur'    => 'UAH',
//            'ik_desc'   => ($balance->type->name.', #'.$balance->id.', '.$request->user()->name.', '.$request->user()->email)
//        ]);
//
//        $ik = new \App\Http\Controllers\Interkassa\InterkassaController();
//        
//        $forms = $ik->getInterkassa($default);
        
        $wfp = new LiqpayController();
        
        $forms = $wfp->createFormBalance($balance);
        
        
        return response()->json(['forms'=>$forms]);
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
     * Метод проверки баланса пользователя перед поддержкой проекта
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function checkBalance(Request $request) {
        if (!$request->ajax()) { return 'некорректный формат запроса';}
        $summa = (int)$request->input('summa',0);
        if ($summa <= 0) { return response()->json (['errors'=>'некорректная сумма']); }
        return response()->json (['success'=>$request->user()->checkmybalance($summa)]); 
    }
}
