<?php

namespace App\Http\Controllers\User;


use App\Models\Billing;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class ShowOperationsController extends Controller
{
    /**
     * Инициализация инстанта
     */
    public function __construct() {
        $this->middleware(['web','auth']); 
    }
    
  
    /**
     * Конторллер одного действия
     * Вывод страницы для выбора действия по балансу пользователя
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        
        $b_first = Billing\Balance::where('user_id', $request->user()->id)
                ->first();
        $b_last = Billing\Balance::where('user_id', $request->user()->id)
                ->latest()
                ->first();
        $b_balance = Billing\Balance::where('user_id', $request->user()->id)
                    ->where('currency_id',1)//UAH
                    ->where('status_id',3)//approved
                    ->sum('summa');
        
        return response()->view('front.user.balance.ShowOperations', ['b_first'=>$b_first,'b_last'=>$b_last,'b_balance'=>$b_balance]);
    }
}
