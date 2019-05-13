<?php

namespace App\Http\Controllers\Front\Sponsors;

use App\Models\Account\UserGifts;
use App\Models\GiftProject\Gift;
use App\Models\Project\Project;
use App\Models\LiqpayForm;
use App\Models\Sponsored\SponsoredStatistic;
use App\Models\Sponsored\Sponsors;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;




use App\Models\Billing\Balance;
use App\Models\Billing\BalanceProjects;
use App\Models\Billing\Order;

use App\Jobs\RejectedBalance;

use App\Http\Controllers\Wayforpay\LiqpayController;
//use App\Http\Controllers\Liqpay\LiqpayController;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderSupportProjectMail;
use Exception;

use Illuminate\Auth\AuthManager  ;

class sponsorsController extends Controller
{
    protected $userFields = ['phone','city','address','comment','ask_question'];


    public function __construct() {
        
        //  Чтобы убрать возможность поддерживать проект без регистрации,
        //  просто уберите метод ->except('postCreate')
        $this->middleware(['web','auth'])->except('postCreate'); 
        
    }

    
    /**
     * Список поддержаных, пользователем проектов
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::with('balance')->whereHas('balance',function($query){
                    return $query->where('user_id',request()->user()->id)->approved();
                })->with(['projectUserGifts'=>function($query){
                        return $query->where('user_id',request()->user()->id);
                }])->paginate(10);
        return response()->view('front.user.user_sponsered_projects', ['projects'=>$projects]);
    }



    /**
     * 
     * @param Request $request
     * @return type
     */
    public function postCreate(Request $request, AuthManager $auth) {
        
        if($auth->guest()){
            return redirect()->guest('newlogin');
        }
      
        $request->session()->forget('redirect_router_project');
        $summa = abs((int)$request->input('summa',0));
        if($summa <= 0) { 
            return back()->with('warning_message', 'Не введена сумма грн ???')->withInput();}
        
        
        $project = Project::active()->find($request->input('project_id',null));
        if (!$project) { return back()->with('warning_message', 'Данные проекта не найдены/не активен, сообщите администрации сайта!')->withInput();}
        
        $quantity = 1;
        $gift = Gift::find($request->input('project_gift_id',null));

        if($gift) {
            if ($gift->project_id != $project->id) { return back()->with('warning_message', 'Награда от другого проекта, сообщите администрации сайта! ')->withInput(); }  
            
            //$quantity = $request->input('quantity',1)?:1;
            if ($gift->getLimitOut($quantity)) { return back()->with('warning_message', 'Исчерпан лимит наград! ')->withInput(); }
            
            if(($quantity*$gift->need_sum) > $summa) { return back()->with('warning_message', 'Минимальная сумма '.($quantity*$gift->need_sum).' грн ! ')->withInput(); }
        } 
  
        $order = Order::create([
            'user_id'           => $request->user()->id,
            'project_id'        => $project->id,
            'project_gift_id'   => $gift?$gift->id:null,
            'quantity'          => $quantity?$quantity:null,
            'summa'             => $summa
        ]);
        
        return redirect()->route('SP_submit',[$project->id, $order->id]);
    }
    
    /**
     * Вывод формы подтверждения поддержки (заказа)
     * @param Request $request
     * @param type $project_id
     * @param type $order_id
     * @return type
     */
    public function submit(Request $request,$project_id,$order_id) {
        
        $request->merge(['project_id' => $project_id,'order_id' => $order_id]);
        
        $valid = $this->validateStore($request);
        if ($valid && isset($valid['error'])) {
            return ($request->isJson())?response()->json($valid):back()->with('warning_message', $valid['error']);
        }
        
        return view('front.project.sponsor.submit',['project'=>$valid['project'], 'order'=>$valid['order']]);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, Order $order)
    {

        return back();
        
//        $project = Project::active()->find($request->input('project_id',null));
//        if (!$project) { return back()->with('warning_message', 'Данные проекта не найдены/не активен, сообщите администрации сайта!')->withInput();}
//        
//        $gift = Gift::find($request->input('project_gift_id',null));
//        
//        if ($gift && ($gift->project_id != $project->id)) {
//            return back()->with('warning_message', 'Награда от другого проекта, сообщите администрации сайта! ')->withInput();
//        }
//        
//        if ($gift->limitOut) { return back()->with('warning_message', 'Исчерпан лимит наград! ')->withInput(); }
//
//        $summa = abs((int)$request->input('summa',0));
//        if(!$request->user()->checkmybalance($summa)) { 
//            $dis = $summa - $request->user()->getMyBalance();
//            return redirect()->route('mybalance.index')->with('warning_message', 'Не хватает '.$dis.' грн.')->withInput();}
//        
//        return view('front.project.sponsor.create',['project'=>$project, 'gift'=>$gift, 'summa'=>$summa]);
    }

    /**
     * Подтверждаем поддержку проекта пользователем
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $valid = $this->validateStore($request);
        if ($valid && isset($valid['error'])) {
            return ($request->ajax())?response()->json($valid):back()->with('warning_message', $valid['error']);
        }

        //дублируем проверку на фронте если оплата с баланса
        if(!$request->ajax() && !$request->user()->checkmybalance($valid['order']->summa)) { return back()->with('warning_message', 'Не хватает денег');}

        $result = $this->supportProject($request, $valid['order']);
        if (is_array($result) && isset($result['error'])) {
            return ($request->ajax())?response()->json($result):back()->with('warning_message', $result['error']);
        }

        if ($request->ajax()) {
            $text_to = 'Поддержка проекта "'. $valid['project']->name.'" №'.$valid['order']->id;

//            $wfp = new WayForPayController();
//            $forms = $wfp->createFormBalance($result,$text_to);
//            return response()->json(['forms'=>$forms]);

            $merchant_id = config('app.public_key');
            $signature = config('app.private_key');

            $liqpay = new LiqpayController($merchant_id, $signature);
            $forms = $liqpay->createFormBalance($result,$text_to);

            return response()->json(['forms'=>$forms]);
        }


        $this->send_mail($valid['order']);

        return redirect(route('project.show',$valid['project']->id))->with('success_message', 'Вы успешно поддержали проект!');
    }

    
    /**
     * Отправить письмо
     * @param Order $order
     */
    protected function send_mail(Order $order){
        Log::info('Отправляем письмо, за поддержку БАЛАНС по ордеру №'.$order->id);
        
        try {
            Mail::send(new OrderSupportProjectMail($order));
            Log::info('успешно');
        } catch (Exception $ex) {
            Log::error('ошибка отправки письма '.$ex->getMessage());
        } 
    }
    
    
    /**
     * Метод поддержки проекта пользователем 
     * @param Request $request
     * @param Order $order
     * @return Balance|array
     */
    protected function supportProject(Request $request, Order $order)
    {
        $ver = $this->validateUserInfo($request, $order);
        
        if (is_string($ver)) { return array('error'=> $ver); }
        
        if ($order->gift) {
            if ($order->gift->limitOut) { return array('error'=> 'Исчерпан лимит наград! '); }
            return $this->supportProjectWithGift($request, $order);
        }
        return $this->supportProjectNoGift($request, $order);
    }

    
    /**
     * Проверит и обновить или выдать сообщение об ошибке
     * @param Request $request
     * @return string|boolean
     */
    protected function validateUserInfo(Request $request, Order $order) {
        //$x = ['phone','city','address','comment','ask_question'];
        $error = [];
        $current  = $this->getCurrentUserFields($request);
        $required = $this->getRequiredUserFields($order);

//        foreach ($required as $key=>$item) {
//            if (!array_key_exists($key, $current)) {
//                $error[] = $item;
//            }
//        }

        if (!empty($error)) {
            return 'Необходимо заполнить: ' . implode(', ', $error) . '.';
        }
        
        $order->update(['userfields'=>$current]);
        return true;
    }
    
    
    /**
     * Получить список необходимых полей для данного ордера
     * @param Order $order
     * @return array
     */
    protected function getRequiredUserFields(Order $order){
        $res['phone']='телефон';
        if (!$order->gift) { return $res;}
        
        if ($order->gift->isDelivery) { $res['city']='город'; $res['address']='адрес';}
        
        if ($order->gift->question_user) { $res['ask_question']='ответ на ворос';}
        
        return $res;
    }

    /**
     * Получить из запроса те что есть из нужного списка доп полей
     * @param Request $request
     * @return array
     */
    protected function getCurrentUserFields(Request $request){
        $res = [];
        foreach ($this->userFields as $value) {
            if ($request->has($value)){ $res[$value] = $request->get($value); }
        }
        return $res;
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return back()->with('warning_message', 'Данные проекта не найдены, сообщите администрации сайта (show)!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return back()->with('warning_message', 'Данные проекта не найдены, сообщите администрации сайта (edit)!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return back()->with('warning_message', 'Данные проекта не найдены, сообщите администрации сайта (update)!');
    }

    /**
     * Метод отказаться от поддержки проекта
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project = Project::with(['balance'=>function($query){
                        return $query->where('user_id',request()->user()->id)->approved();
                    }])->with(['projectUserGifts'=>function($query){
                        return $query->where('user_id',request()->user()->id);
                    }])->whereHas('balance')->find($id);
                    
        if (!$project) { return back()->with('warning_message', 'Данные проекта не найдены, сообщите администрации сайта (destroy)!');}
        
        if(!$project->isActive) { return back()->with('warning_message', 'Невозможно отказаться от поддержки проекта, статус :'.$project->statusName);}
        
        $summa      = -$project->balance->sum('summa');

        foreach ($project->balance as $balance) {
            dispatch(new RejectedBalance($balance));
        }

        
        return redirect()->back()->with('success_message',('Вы отказались поддерживать проект '.$project->name.', сумма '.$summa.' грн возвращена на баланс'));        
    }
    

    /**
     * Создаём запись в балансе, в заваисмости от типа запроса и наличия подарков
     * @param Request $request
     * @param Order $order
     * @return Balance
     */
    protected function createBalance(Request $request,Order $order) {
        
        $opreation_type = $request->ajax()?2:($order->gift?4:3); //2 -addApi for interkassa, 4 with gift, 3 donate;
        $summa          = $request->ajax()?$order->summa:-$order->summa;//+ for interkassa, - for balance
        $status_id      = $request->ajax()?1:3;//1 sending for interkassa, 3 - approved

        $userbalance =  Balance::create([
            'summa'             => $summa,
            'user_id'           => $order->user_id,
            'currency_id'       => 1, //UAH
            'operation_type_id' => $opreation_type, 
            'status_id'         => $status_id,
        ]);

        $order->update(['balance_id'=>$userbalance->id]);
        return $userbalance;
    }
    
    /**
     * Метод поддержки проекта пользователями без подарка
     * @param Request $request
     * @param Order $order
     * @return Balance
     */
    protected function supportProjectNoGift(Request $request,Order $order)
    {

        $userbalance = $this->createBalance($request, $order);

        if (!$request->ajax()) {
            BalanceProjects::create([ 'balance_id' => $userbalance->id, 'project_id' => $order->project_id ]);
        }
 
        return $userbalance;
        
//        dd($userbalance,$balanceproject);
//
//        $project = Project::find($id);
//        if (!$project) {
//            return back()->with('warning_message', 'Данные проекта не найдены сообщите администрации сайта!');
//        }
//        $this->validate($request, [
//            'support_sum' => 'required',
//        ]);
//        if(Auth::user()->account->balance < $request->support_sum){
//            return redirect(route('personal_area.index'))->with('warning_message','У Вас недостаточно денег на балансе!');
//        }
//        $finish_balance = Auth::user()->account->balance - $request->support_sum;
//        Auth::user()->account()->update([
//            'balance'=>$finish_balance
//        ]);
//        $res_sum = $project->current_sum + $request->support_sum;
//        $project->update([
//            'current_sum' => $res_sum
//        ]);
//        $this->addSponsor(Auth::id(), $project->id, $request->support_sum);
            


    }
    
    
    /**
     * Метод поддержки проекта пользователями c подарком
     * @param Request $request
     * @param Order $order
     * @return Balance
     */
    protected function supportProjectWithGift(Request $request, Order $order) {
        
        $userbalance = $this->createBalance($request, $order);

        UserGifts::create([
            'user_id'       => $order->user_id,
            'gift_id'       => $order->project_gift_id,
            'balance_id'    => $userbalance->id,
            'project_id'    => $order->project_id,
            'status_id'     => 1, //zakaz
            //'delivery'      => $request->except('_token'),
            'quantity'      => $order->quantity,
            'order_id'      => $order->id
        ]);
        
        if (!$request->ajax()) {
            BalanceProjects::create(['balance_id'    => $userbalance->id,'project_id'    => $order->project_id ]);
            $order->update(['status_id'=>3]);
        }
        
        return $userbalance;
    }
    
    /**
     * Проверка запроса project_id && order_id && $request->user()
     * @param Request $request
     * @return array
     */
    protected function validateStore(Request $request) {
        $project = Project::active()->find($request->input('project_id',null));
        if (!$project) { 
            return array('error'=>'Данные проекта не найдены, сообщите администрации сайта!');}
        
        $order  = Order::with(['user','gift'])
                ->whereNull('balance_id')
                ->where('user_id',$request->user()->id)
                ->find($request->input('order_id',null));
        if (!$order) { 
            if (Order::with(['user','gift'])->find($request->input('order_id',null))) {
                return array('error'=>'Заказ оформлен ранее и ожидает оплату!');
            }
            return array('error'=>'Данные заказа не найдены, сообщите администрации сайта!');}
        
        if($order->project_id != $project->id) { 
            return array('error'=>'Заказ не к этому проекту, сообщите администрации сайта!'); }
        
        if($request->user()->id != $order->user_id) {
            return array('error'=> 'Не найден ВАШ заказ!');
        } 
        
        return array('project'=>$project,'order'=>$order);
    }
    


//    /**
//     * Метод добавления или изменения записи про спонсора проекта
//     * @param int $user_id
//     * @param int $project_id
//     * @param int $sum
//     */
//    protected function addSponsor($user_id, $project_id, $sum, $project_gift_id = NULL)
//    {
//        if (isset($user_id) and isset($project_id) and isset($sum)) {
//            $sponsor = Sponsors::where('user_id', $user_id)->where('project_id', $project_id)->first();
//            if ($sponsor) {
//                $res_sum = $sponsor->sum + $sum;
//                $sponsor->update([
//                    'sum' => $res_sum
//                ]);
//            } else {
//                $new_sponsor = new Sponsors();
//                $new_sponsor->user_id = $user_id;
//                $new_sponsor->project_id = $project_id;
//                $new_sponsor->sum = $sum;
//                $new_sponsor->save();
//            }
//            $this->addOrderStatisticSponsor($user_id, $project_id, $project_gift_id, $sum);
//        }
//    }
//
//    /**
//     * Метод записи данных в таблицу статистики поддержки проекта
//     * @param int $user_id
//     * @param int $project_id
//     * @param null $project_gift_id
//     * @param int $sum
//     */
//    protected function addOrderStatisticSponsor($user_id, $project_id, $project_gift_id = NULL, $sum)
//    {
//        if (isset($user_id) and isset($project_id) and isset($sum)) {
//            $new_order = new SponsoredStatistic();
//            $new_order->user_id = $user_id;
//            $new_order->project_id = $project_id;
//            if (isset($project_gift_id)) {
//                $new_order->project_gift_id = $project_gift_id;
//            }
//            $new_order->sum = $sum;
//            $new_order->save();
//        }
//    }
//
//
//    public function giftSupportProject(Request $request, $id)
//    {
//        if (Auth::check()) {
//            $project = Project::find($id);
//            if (!$project) {
//                return back()
//                    ->with('warning_message', 'Ошибка при поиске информации о проекте. Сообщите адимнистратору сайта');
//            }
//            $this->validate($request, [
//                'project_gift_id' => 'required'
//            ]);
//            $check_gift = Gift::find($request->project_gift_id);
//            if (!$check_gift) {
//                return back()
//                    ->with('warning_message', 'Ошибка при поиске информации о проекте. Сообщите адимнистратору сайта');
//            }
//            if(Auth::user()->account->balance < $check_gift->need_sum){
//                return redirect(route('personal_area.index'))->with('warning_message','У Вас недостаточно денег на балансе!');
//            }
//            $finish_balance = Auth::user()->account->balance - $check_gift->need_sum;
//            Auth::user()->account()->update([
//                'balance'=>$finish_balance
//            ]);
//            $new_user_gift = new UserGifts();
//            $new_user_gift->user_id = Auth::id();
//            $new_user_gift->gift_id = $check_gift->id;
//            $new_user_gift->save();
//            $count_gift = $check_gift->limit - 1;
//            $check_gift->update([
//                'limit'=>$count_gift
//            ]);
//            $res_sum = $project->current_sum + $check_gift->need_sum;
//            $project->update([
//                'current_sum' => $res_sum
//            ]);
//            $this->addSponsor(Auth::id(), $id, $check_gift->need_sum, $check_gift->id);
//            return back()->with('success_message', 'Вы успешно поддержали проект !');
//        }
//        return redirect('/login');
//    }
    
}
