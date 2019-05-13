@extends('layouts.app')
@section('title','Заявка на возврат средств #'.$refund->id)
@section('content')
    <div class="wrap">
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="money_wrap">
                            <h2 class="caption">{{trans('user_profile.askmoneyfor')}}</h2>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="money_rules">
                            <h3>{{trans('user_profile.zajava')}}</h3>

                            <div>
                                <img class="media_profile img-responsive"
                                     src="{{ Storage::url($refund->declaration) }}" 
                                     alt="">
                            </div>
                            
                            <label>Статус</label>
                            <p>{{ $refund->status->name }}</p>
                            
                            <label>Дата подачи</label>
                            <p>{{ $refund->created_at }}</p>

                            @if($refund->status->id !=1 )
                                <label>Дата ответа</label>
                                <p>{{ $refund->updated_at }}</p>
                                
                                @if($refund->admin)
                                    <label>Адиминистратор</label>
                                    <p>{{ $refund->admin->name }}</p>
                                @endif
                                
                                @if($refund->admin_text)
                                    <label>Комментарий администратора</label>
                                    <p>{{ $refund->admin_text }}</p>
                                @endif
                                
                                @if($refund->balance)
                                    <label>Номер в записи Вашего баланса</label>
                                    <p>{{ $refund->balance->id }}</p>
                                @endif
                                
                            @endif

                            <label>{{trans('user_profile.summ')}}</label>
                            <p>{{ $refund->summa }} {{ $refund->currency->langOf()->name}}</p>


                            <label>{{trans('user_profile.datacard')}}</label>
                            <p>{{ $refund->userpaymethod->name }} {{ $refund->userpaymethod->code }}</p>
                            @if($refund->userpaymethod->description)
                                <p>{{ $refund->userpaymethod->description }}</p>
                            @endif
                            
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <a href="{{ route('mybalance.index') }}" class="btn btn-info">Назад, Мои финансы</a>
                    &nbsp;&nbsp;&nbsp;<a href="{{route('refund.index')}}" class="btn btn-info">Назад, Мои заявки</a>
                </div>
                
            </div>
        </section>
    </div>
@endsection