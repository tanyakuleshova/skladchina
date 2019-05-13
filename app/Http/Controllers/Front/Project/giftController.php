<?php

namespace App\Http\Controllers\Front\Project;

use App\Models\GiftProject\Gift;
use App\Models\Project\Project;
use App\Models\GiftProject\GiftDelivery;

use App\Http\Controllers\Front\Project\EditSteps\ThirdStepController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Jobs\ImageResizeRulesRatio;
//use File;
//use Image;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class giftController extends Controller
{
    /**
     *  //TODO список подарков
     */
    public function index() {
    }
    
    /**
     * Отобразить форму для создания подарка
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $v_p = $this->validateProjectId($request);
        if ($v_p) { return $v_p; }
        
        $deliveries = GiftDelivery::with(['lang'=>function($querry){
                return $querry->current();
            }])->get();

        return view('front.gifts.create', ['project_id'=>$request->get('project_id'),'deliveries'=>$deliveries]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $v_p = $this->validateProjectId($request);
        if ($v_p) { return $v_p; }
        
        $deliveries = GiftDelivery::with(['lang'=>function($querry){
                return $querry->current();
            }])->get();
            
        $v_g = $this->validateGift($request);
        if ($v_g->fails()) {
            return view('front.gifts.create',['project_id'=>$request->get('project_id'),'deliveries'=>$deliveries])->withErrors($v_g)->with($request->input());
        }

        $add_gift = new Gift();
        $gift = $this->UpdateOrSaveGift($request, $add_gift);
        

        
        return [
            'forma' => view('front.gifts.create',       ['project_id'=>$request->get('project_id'),'deliveries'=>$deliveries])->render(),
            'gift'  => view('front.gifts.view_small',   ['gift'=>$gift,'add'=>true])->render()
        ];
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $gift = Gift::find($id);
        if (!$gift) { return null;}
        
        $small = $request->get('small');
        if ($small) {
            return view('front.gifts.view_small',  compact('gift'));
        }
        if ($request->isJson()) {

        }
        
        
    }

    /**
     * Отображаем форму для редактирования
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $v_p = $this->validateProjectId(request());
        if ($v_p) { return $v_p; }
        
        $gift = Gift::find($id);
        if (!$gift) { return request()->isJson()?['errors'  => 'не такой награды']:null;}

        $deliveries = GiftDelivery::with(['lang'=>function($querry){
                return $querry->current();
            }])->get();
        
        return [
            'forma' => view('front.gifts.edit',       ['ajax'=>true,'gift'=>$gift,'project_id'=>request()->get('project_id'),'deliveries'=>$deliveries])->render()
        ];
        
    }

    /**
     * Метод обновления подарка
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $v_p = $this->validateProjectId(request());
        if ($v_p) { return $v_p; }
        
        $gift = Gift::find($id);
        if (!$gift) { return $request->isJson()?['errors'  => 'не такой награды']:null;}
        
        $v_g = $this->validateGift($request);
        if ($v_g->fails()) {
            $deliveries = GiftDelivery::with(['lang'=>function($querry){
                    return $querry->current();
                }])->get();
            return ['forma'   => view('front.gifts.edit',['ajax'=>true,'gift'=>$gift,'project_id'=>$request->get('project_id'),'deliveries'=>$deliveries])->withErrors($v_g)->with($request->input())->render(),
                    'errors'  => 'не пройдена валидация'];   
        }
        
        $gift_edit = $this->UpdateOrSaveGift($request, $gift);
        
        return [
            'success'   => true,
            'gift'  => view('front.gifts.view_small',   ['gift'=>$gift ])->render()
        ];
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $gift = Gift::find($id);
        if (!$gift) { return ['errors'=>' неизвестный ID '];}
        
        $v_p = $this->validateProjectId($request);
        if ($v_p) { return $v_p; }
        
        if ($gift->project_id != $request->get('project_id')) {
            return ['errors'=>' Подарок принадлежит другому проекту '];
        }

        $project = $gift->project;
        $gift->forceDelete();
        
        ThirdStepController::validateUpdate($project);
        
        return 'true';
        
    }
    
    
    protected function validateProjectId(Request $request) {
        $project_id = $request->get('project_id');
        if(!$project_id) {return ['errors'=>'Нет project_id']; }
        
        $project = Project::find($project_id);
        if(!$project){ return ['errors'=>'Нет такого проекта, id='.$project_id]; }
        
        $user = $request->user();
        if ($user->id != $project->user_id ) { return ['errors'=>'Проект не принадлежит пользователю , '.$user->name]; }
        
    }
    
    protected function validateGift(Request $request) {
        return Validator::make($request->all(),[ 
                'need_sum'          => 'required',
                'name'              => 'required',
                'description'       => 'required',
                'image_gifts'       => 'sometimes|mimes:jpeg,bmp,png',
                //'image_gifts'=>($edit?'sometimes|mimes:jpeg,bmp,png':'required|mimes:jpeg,bmp,png'),
                //'date'=>'required',
                'delivery_method'   => 'required|in:10,20,30']
                ,[
                'need_sum.required'     =>'Сумма обязательна.',
                'name.required'         =>'Название вознаграждения обязательно.',
                'description.required'  =>'Описание обязательно.',
                'image_gifts.required'  =>'Обязательно изображение',
                'image_gifts.mimes'     =>'Допустимы типы изображнеий: jpeg,bmp,png',   
                //'date.required'=>'Данное поле обязательное.',
                'delivery_method.required'=>'Способ доставки обязателен.'
                ]);
        
    }
    

    /**
     * Метод для записи или обновления подарка
     * @param Request $request
     * @param Gift $gift
     * @return Gift
     */
    protected function UpdateOrSaveGift(Request $request,Gift $gift) {
        $gift->project_id       = $request->get('project_id');
        $gift->need_sum         = abs($request->need_sum);
        $gift->name             = str_limit($request->input('name', ''),130);
        $gift->limit            = is_null($request->input('limit',0))?0:$request->input('limit',0);
        $gift->delivery_method  = 'наследие, удалить';
        $gift->delivery_id      = abs($request->input('delivery_method',10));
        $gift->description      = $request->input('description','');
        $gift->question_user    = is_null($request->input('question_user'))?'':$request->input('question_user');
        $gift->duration         = $request->input('duration','');

        if($gift->project->isActive && $gift->duration) {
            $gift->delivery_date    = Carbon::parse($gift->project->date_finish)->addDays($gift->duration);
        } else {
            $gift->delivery_date    = '0001-01-01';
        }

        if ($request->hasFile('image_gifts')) {
            Storage::disk('public')->delete($gift->image_link);
            $gift->image_link = $request->file('image_gifts')->storePublicly('project/'.$request->get('project_id').'/gifts','public');
            dispatch(new ImageResizeRulesRatio(400, 300, $gift->image_link));
            //Image::make(Storage::disk('public')->path($gift->image_link))->widen(600)->resizeCanvas(600, 300)->save(Storage::disk('public')->path($gift->image_link))->destroy();
        } elseif(!$gift->image_link) {
            $gift->image_link = '';
        }
        $gift->save();
        
        ThirdStepController::validateUpdate($gift->project);
        return $gift;
    }
    
    
}
