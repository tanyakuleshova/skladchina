@extends('admin.layouts.admin-app')
@section('admin_style')
<link href="{{asset('administrator/css/plugins/slick/slick.css')}}" rel="stylesheet">
<link href="{{asset('administrator/css/plugins/slick/slick-theme.css')}}" rel="stylesheet">
@endsection
@section('admin_content')
<div class="wrapper wrapper-content  animated fadeInDown article details_project">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">
            <div class="ibox">
                <div class="pull-left">
                    <div class="alert">Линк: {{route('show_project',[$project->id,$project->SEO])}}</div>
                </div>
                <div class="pull-right">
                    <div class="alert alert-danger">{{ $project->statusName }}</div>
                </div>
                <div class="ibox-content">
                    <div class="text-center article-title">
                        <h2>
                            {{$project->name}}
                        </h2>
                    </div>
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Основное</a></li>
                        <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Подробней</a></li>
                        <li role="presentation"><a href="#gifts" aria-controls="gifts" role="tab" data-toggle="tab">Подарки</a></li>
                        <li role="presentation"><a href="#requisites" aria-controls="requisites" role="tab" data-toggle="tab">Реквизиты</a></li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="home">
                            <div class="details_project_info">
                                <p><strong>Название :</strong> {{$project->name}}</p>                            
                                <p><strong>Автор :</strong> {!! $project->author?'<a href="'.route('users.show',$project->author->id).'">'.$project->author->fullName.'</a>':'---'!!}</p>
                                <p><strong>Город :</strong> {{ $project->city?$project->city->name:'---' }}</p>
                                <p><strong>Категория :</strong> {{ $project->category?$project->category->name:'---' }}</p>
                                <p><strong>Необходимая сумма :</strong> {{ $project->need_sum }}</p>
                                <p><strong>Собранная сумма :</strong> {{ $project->current_sum }}</p>
                                <p><strong>Тип :</strong> {{ $project->type?$project->type->name:'---' }}</p>
                                <p><strong>Начало :</strong> {{ $project->startData }}</p>
                                @if($project->isActive && $project->type_id != 2)
                                <p><strong>Окончание :</strong> {{ $project->finishData }}</p>
                                @endif
                                <p><strong>Краткое описание :</strong> {{ $project->short_desc }}</p>
                            </div>

                        </div>
                        <div role="tabpanel" class="tab-pane" id="profile">
                            <div class="details_project_img">
                                <img class="img-circle" src="{{ asset($project->poster) }}" alt="">
                            </div>
                            <hr>
                            <p>{{$project->short_desc}}</p>
                            <p>{!! $project->description !!} </p>


                        </div>
                        <div role="tabpanel" class="tab-pane" id="gifts">
                            @if($project->project_giftt_type == 1)
                            <h4 class="text-center m">
                                Подарки проекта {{$project->name}}
                            </h4>
                            @foreach($project->projectGifts as $gift)
                            <div>
                                <div class="ibox-content">
                                    <img src="{{asset($gift->image)}}" width="250" height="250" >
                                    <p>
                                        {!! $gift->description !!}
                                    </p>
                                    <div class="col-sm-4">
                                        <div class="font-bold">Лимит</div>
                                        {{$gift->limit}}
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="font-bold">Стоимость</div>
                                        {{$gift->need_sum}} грн
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="font-bold">Способ доставки</div>
                                        {{$gift->deliveryMethod}}
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @endif
                        </div>

                        <div role="tabpanel" class="tab-pane" id="requisites">
                            <div class="row">
                                <div class="col-lg-12">
                                    <h2>Сканы :</h2>
                                    @if($project->requisites)
                                    @if($project->requisites->galleries)
                                    @foreach($project->requisites->galleries as $gallery)
                                    <img width="500" height="500" src="{{asset($gallery->image)}}"></a>
                                    @endforeach
                                    @endif
                                    @endif
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-lg-12 details_project_aboutProject">
                                    <h2>Реквизиты :</h2>
                                    @if($project->requisites)
                                    @if($project->requisites->type_proj == 'individual')
                                    <h3>Юридична особа</h3>
                                    <span>Посада: </span><strong>{{$project->requisites->position}}</strong>
                                    <br>
                                    <span>ПІБ: </span><strong>{{$project->requisites->FIO}}</strong>
                                    <br>
                                    <span>Повна назва організації: </span>
                                    <strong>{{$project->requisites->name_organ}}</strong>
                                    <br>
                                    <span>Країна реєстрації: </span>
                                    <strong>{{$project->requisites->country_register}}</strong>
                                    <br>
                                    <span>Місто: </span><strong>{{$project->requisites->city}}</strong>
                                    <br>
                                    <span>Телефон: </span><strong>{{$project->requisites->phone}}</strong>
                                    <br>
                                    <span>Код ЄДРПОУ: </span><strong>{{$project->requisites->inn_or_rdpo}}</strong>
                                    <br>
                                    <span>Юридична адреса: </span>
                                    <strong>{{$project->requisites->legal_address}}</strong>
                                    <br>
                                    <span>Фактична адреса: </span>
                                    <strong>{{$project->requisites->physical_address}}</strong>
                                    <br>
                                    <span>Код банку: </span><strong>{{$project->requisites->code_bank}}</strong>
                                    <br>
                                    <span>Розрахунковий рахунок: </span>
                                    <strong>{{$project->requisites->сhecking_account}}</strong>
                                    <br>
                                    <span>Інше: </span><strong>{{$project->requisites->other}}</strong>
                                    <br>
                                    @elseif($project->requisites->type_proj == 'FOP')
                                    <h3>Фізична особа</h3>
                                    <span>ПІБ: </span><strong>{{$project->requisites->FIO}}</strong>
                                    <br>
                                    <span>Дата народження: </span><strong>{{$project->requisites->date_birth}}</strong>
                                    <br>
                                    <span>Країна реєстрації: </span><strong>{{$project->requisites->country_register}}</strong>
                                    <br>
                                    <span>Місто: </span><strong>{{$project->requisites->city}}</strong>
                                    <br>
                                    <span>Телефон: </span><strong>{{$project->requisites->phone}}</strong>
                                    <br>
                                    <span>ІНН: </span><strong>{{$project->requisites->inn_or_rdpo}}</strong>
                                    <br>
                                    <span>Ким виданий : </span><strong>{{$project->requisites->issued_by_passport}}</strong>
                                    <br>
                                    <span>Коли виданий: </span><strong>{{$project->requisites->date_issued}}</strong>
                                    <br>
                                    <span>Код банку: </span><strong>{{$project->requisites->code_bank}}</strong>
                                    <br>
                                    <span>Розрахунковий рахунок: </span><strong>{{$project->requisites->сhecking_account}}</strong>
                                    <br>
                                    <span>Інше: </span><strong>{{$project->requisites->other}}</strong>
                                    <br>
                                    @else
                                    <h3>Підприємець</h3>
                                    <span>Найменування / ПІБ: </span><strong>{{$project->requisites->FIO}}</strong>
                                    <br>
                                    <span>Країна реєстрації: </span><strong>{{$project->requisites->country}}</strong>
                                    <br>
                                    <span>Місто: </span><strong>{{$project->requisites->city}}</strong>
                                    <br>
                                    <span>Телефон: </span><strong>{{$project->requisites->phone}}</strong>
                                    <br>
                                    <span>Код ЄДРПОУ: </span><strong>{{$project->requisites->inn_or_rdpo}}</strong>
                                    <br>
                                    <span>Юридична адреса: </span><strong>{{$project->requisites->legal_address}}</strong>
                                    <br>
                                    <span>Фактична адреса: </span><strong>{{$project->requisites->physical_address}}</strong>
                                    <br>
                                    <span>Код банку: </span><strong>{{$project->requisites->code_bank}}</strong>
                                    <br>
                                    <span>Розрахунковий рахунок: </span><strong>{{$project->requisites->сhecking_account}}</strong>
                                    <br>
                                    <span>Інше: </span><strong>{{$project->requisites->other}}</strong>
                                    <br>
                                    @endif
                                    @endif

                                </div>
                            </div>




                        </div>
                    </div>








                    <hr>
                    <hr>
                    <div class="row">                        
                        <a class="btn btn-info" href="{{route('a_allprojects.index')}}">К списку всех проектов</a>
                        @if(Auth::guard('admin')->user()->isAdmin == 1)
                        <form action="{{route('a_allprojects.update',$project->id)}}" method="post">
                            {{csrf_field()}}
                            {{ method_field('PUT') }}

                            <div class="form-group">
                                <label for="admin_id" class="control-label">Администратор</label>
                                <select class="form-control" name="admin_id">
                                    @foreach($admins as $admin)
                                    <option value="{{ $admin->id }}"
                                            @if($admin->id == $project->admin_id) selected @endif>{{ $admin->fullName }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label class="control-label">
                                    @if($project->level_project)
                                        <input type="checkbox"  name="level_project" value="1" checked>&nbsp;&nbsp;Выбор редакции ?
                                    @else
                                        <input type="checkbox"  name="level_project" value="1">&nbsp;&nbsp;Выбор редакции ?
                                    @endif
                                </label>
                            </div>
                            
                            <button class="btn btn-success">Обновить проект</button>
                        </form> 
                        @else
                        <div class="form-group">
                            <label for="admin_id" class="control-label">Администратор</label>
                            <p>{{ $admins->first()->fullName }}</p>
                        </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .slick_demo_2 .ibox-content {
        margin: 0 10px;
    }
</style>
@endsection
@section('admin_script')
<script src="{{asset('administrator/js/plugins/slick/slick.min.js')}}"></script>
<script>
$(document).ready(function () {


    $('.slick_demo_1').slick({
        dots: true
    });

    $('.slick_demo_2').slick({
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 1,
        centerMode: true,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    infinite: true,
                    dots: true
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });

    $('.slick_demo_3').slick({
        infinite: true,
        speed: 500,
        fade: true,
        cssEase: 'linear',
        adaptiveHeight: true
    });
});

</script>
@endsection