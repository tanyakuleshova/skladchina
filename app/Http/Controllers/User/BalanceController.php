<?php

namespace App\Http\Controllers\User;

use App\Models\Billing;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


use App\Http\Controllers\Wayforpay\LiqpayController;

class BalanceController extends Controller
{
    public function __construct() {
        $this->middleware(['web','auth']); 
    }
    
    /**
     * Список операций по балансу, пользователя
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $balancies = Billing\Balance::where('user_id',Auth::id())
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

        $text_to = 'Пополнение баланса "'.$request->user()->fullName.'" №'.$balance->id;

//        $wfp = new WayForPayController();
        $merchant_id = config('app.public_key');
        $signature = config('app.private_key');
        $liqpay = new LiqpayController($merchant_id, $signature);
        $forms = $liqpay->createFormBalance($balance,$text_to);
        
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
