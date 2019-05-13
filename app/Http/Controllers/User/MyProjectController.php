<?php

namespace App\Http\Controllers\User;



use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use App\Models\Project\Project;

class MyProjectController extends Controller
{
    public function __construct() {
        $this->middleware(['web','auth']); 
    }
    
    /**
     * Список Проектов пользователя
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $active_pro         = Project::where('user_id',Auth::id())->active()->get();
        $moderation_pro     = Project::where('user_id',Auth::id())->moderation()->get();
        $new_my_pro         = Project::where('user_id',Auth::id())->allEdited()->orderBy('status_id','desc')->get();
        $closed_pro         = Project::where('user_id',Auth::id())->allClosed()->orderByRaw('FIELD(status_id,40,60,50)')->get();
        
        return view('front.user.myproject.list',compact('active_pro','moderation_pro','new_my_pro','closed_pro'));
    }


    /**
     * Форма 
     * @todo этот метод нужно ещё реализовать
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->view('front.user.balance.form_add_balance');
    }
    
    /**
     * Метод создания новой записи
     * @todo этот метод нужно ещё реализовать
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

    }
    
    /**
     * Метод изменения записи
     * @todo этот метод нужно ещё реализовать
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {

    }
    
    /**
     * Метод вывода представления просотра записи
     * @todo этот метод нужно ещё реализовать
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = Project::where('user_id',Auth::id())->closedSuccess()->findOrFail($id);
        
        //dd($project->orders);
        return view('front.user.myproject.sponsored.show_list',compact('project'));
    }
    
    public function getAjaxOrders($id){
        $project = Project::with(['orders'=>function($query){
            $query->approved();
        }])->where('user_id',Auth::id())->closedSuccess()->findOrFail($id);
        
        $res = [];
        foreach ($project->orders as $order) {
            if (!$order->usergifts) { 
                $status = '';
            }elseif($order->history && isset($order->history['send'])) {
                $status = $order->history['send'];
            }else {
                $status = $order->gift->deliveryMethod;
            }
            
            $child = view('front.user.myproject.sponsored.part_one_order',  compact('order'))->render();
            
            $res['data'][] = [
                'name'      => $order->user->fullName,
                'email'     => $order->user->email,
                'summa'     => $order->summa,
                'gift'      => $status,
                'created'   => $order->created_at->toDateTimeString(),
                'updated'   => $order->updated_at->toDateTimeString(),   
                'child'     => $child
            ];
        }
        return response()->json($res);
    }
    
    public function sendGiftToUser($idp,$ido){
        $project = Project::with(['orders'=>function($query) use ($ido){
            $query->approved()->where('id',$ido);
        }])->where('user_id',Auth::id())->closedSuccess()->find($idp);
        
        if (!$project) { return response()->json(['error'=>'Неизвестный проект']); }
        if (!$project->orders) { return response()->json(['error'=>'Неизвестный ордер']); }
        
        $ord = $project->orders->first();
        
        if ($ord->history && isset($ord->history['send'])) {
            return response()->json(['success'=>  $ord->history['send']]);
        }
        
        $ord->update(['history'=>['send'=>Carbon::now()->toDateTimeString()]]);

        
        return response()->json(['success'=>  Carbon::now()->toDateTimeString()]);
    }

}
