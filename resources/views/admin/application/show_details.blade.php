@extends('admin.layouts.admin-app')
@section('admin_content')
    <div class="wrapper wrapper-content  animated bounceInDown">
        <div>
            <div class="ibox ">
                <div class="ibox-content text-center">

                    <h3 class="m-b-xxs">Изображение заявки</h3>
                    <img src="{{asset($application->application_image)}}">
                </div>
            </div>
            <div class="social-feed-separated">
                <div class="social-feed-box">
                    <div class="social-avatar">
                        <a href="{{route('users.show',$application->user_id)}}">
                            {{$application->sender->name.' '.$application->sender->last_name}}
                        </a>
                        <small class="text-muted">{{$application->created_at}}</small>
                    </div>
                    <div class="social-body">
                        <p><span>Сумма: </span>{{$application->money_sum}} грн</p>
                        <p>{{$application->type_cart}}</p>
                        <p><span>Номер счета: </span> {{$application->number_score}}</p>
                        <a class="btn btn-primary" href="{{redirect()->back()->getTargetUrl()}}">Назад</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection