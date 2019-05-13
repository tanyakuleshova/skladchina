{{-- Форма для получения награды проекта --}}
{{-- $project , $order --}}
@extends('layouts.app')
@section('title','Подтверждение поддержки')


@section('head-script')
    <script type="text/javascript" src="{{asset('js/submit_support.js')}}"></script>
@endsection

@section('content')
<section class="wrap">
    <div class="container">
        <div class="get-rewards-form">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="create_title"><span class="greeny">{{ $project->name }}. Заказ № {{ $order->id }}</span></h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="create_project get-rewards-info">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="get-rewards-rules">
                                    <label>Прекрасный выбор! Наши поздравления.</label>
                                    <p>Осталось совсем чуть-чуть. Пожалуйста, заполните эту анкету, это поможет
                                        автору при отправлении награды, а также даст ему возможность связаться с
                                        вами.</p>
                                    <p>Данные, указанные в анкете, будут доступны только для автора проекта и
                                        только в случае его успеха. Информация не предназначена для публичной
                                        огласки.</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="get-rewards-info-left">
                                    <h2></h2>
                                    
                                    @if($order->gift)
                                    
                                        <div class="rewards_wrap_img">
                                            <img src="{{asset($order->gift->image)}}"/>
                                        </div>
                                        <div class="rewards_wrap_text">
                                            {!! $order->gift->description !!}
                                        </div>
                                        <div>
                                            <label>Доставка:</label>
                                            {{ $order->gift->deliveryMethod }},
                                            {{ $order->gift->delivery_date }}
                                        </div>
                    
                                    @endif
                                    
                                </div>

                            </div>
                            <div class="col-md-6">
                    <div>
                                    <label>Получатель:</label>
                                    {{ Auth::user()->fullName }}
                                </div>
                                <div>
                                    <label>Email:</label>
                                    {{ Auth::user()->email }}
                                </div>
                                    <form action="{{route('support_project.store')}}" 
                                      method="post" 
                                      data-check="{{ route('check_my_balance') }}">
                                    {{csrf_field()}}
                                    <input type="hidden" name="project_id" value="{{ $project->id }}">
                                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                                    <input type="hidden" name="summa" value="{{ $order->summa }}">
                                    <div>
                                        <label>Сумма:</label>
                                        {{ $order->summa }} грн.
                                    </div>
                                    <label>Телефон:</label>
                                    <input type="text" name="phone" value="{{ old('phone')?old('phone'):Auth::user()->account->contact_phone }}" >
                                    
<!--                                    @if($order->gift && $order->gift->isDelivery)-->
<!--                                        <label>Город:</label>-->
<!--                                        <input type="text" name="city" value="{{ old('city')?old('city'):Auth::user()->city }}" required="required">-->
<!---->
<!--                                        <label>Адрес:</label>-->
<!--                                        <input type="text" name="address" required="required" value="{{ old('address') }}">-->
<!--                                    @endif-->
                                    
                                    <label>Комментарий:</label>
                                    <textarea type="text" name="comment">{{ old('comment')}}</textarea>

                                    @if($order->gift && $order->gift->question_user)
                                        <label>Вопрос от создателей проекта:</label>
                                        <p>{{ $order->gift->question_user }}</p>
                                        <input type="text" name="ask_question" required="required" value="{{ old('ask_question') }}">
                                    @endif
                                    
                                    <div class="get-rewards-right-btn">
                                        <button class="btn _support_project_card" >Оплата с карты</button>
                                        <button class="btn _support_project_balance">Оплата с баланса</button>
                                    </div>

                                </form>

                                <div class="clearfix"><br/></div>
                                
                                        </div>
                                        
                
                        <div class="col-md-12 otkaz">
                            <a class="btn btn-grey col-md-3"
                                href="{{ route('project.show',$project->id)}}"
                                title="Отказаться">Отказаться
                            </a>
                            
                                <p class="col-md-9">Нажимая на Перейти к оплате вы соглашаетесь с <a href="/rules_service" target="_blank">Правилами</a> и <a href="/agreement" target="_blank">Условиями пользования</a>.</p>
                            
                        </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
    </div>
</section>
@endsection


