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
                <div class="pull-right">
                    <a href="{{route('change_mode_status',[2,$project->id])}}"
                    class="btn @if($project->mod_status == 2) btn-primary @else btn-white @endif btn-md"
                     type="button">Активен
                 </a>
                 <a href="{{route('change_mode_status',[0,$project->id])}}"
                     class="btn @if($project->mod_status == 0) btn-primary @else btn-white @endif btn-md"
                     type="button">Сохранен
                 </a>
                 <a href="{{route('change_mode_status',[3,$project->id])}}"
                     class="btn @if($project->mod_status == 3) btn-primary @else btn-white @endif btn-md"
                     type="button">Закрыт
                 </a>
            </div>
            <div class="ibox-content">

                <div class="text-center article-title">
                    @if($project->mod_status == 1)
                    <div class="alert alert-danger">На модерации</div>
                    @endif
                    <!-- <span class="text-muted"><i class="fa fa-clock-o"></i> {{$project->created_at}}</span> -->
                    <h1>
                        {{$project->name}}
                    </h1>
                </div>

                <div class="details_project_img">
                   <img class="img-circle" src="{{asset($project->poster_link)}}" alt="">
               </div>
               <div class="details_project_info">
                @if($project->categoryProject)
                <span><strong>Категория :</strong> {{$project->categoryProject->name}}</span>
                @endif
                <br>
                @if($project->status)
                <span><strong>Вид проекта :</strong> {{$project->status->name}}</span>
                @endif
                <br>
                @if($project->status->name != "Безстроковий")
                <span><strong>Дата окончания :</strong> {{$project->date_finish}}</span>
                <br>
                @endif
                <span><strong>Расположение :</strong> {{$project->location}}</span>
                <br>

                <span><strong>Собранная сумма :</strong> {{$project->current_sum}}</span>

            </div>
            <hr>
            <p>
                {{$project->short_desc}}
            </p>
            <p>{!! $project->description !!} </p>
            <hr>
            @if($project->project_giftt_type == 1)
            <div class="row">
                <div class="col-lg-10 col-lg-offset-1">
                    <h4 class="text-center m">
                        Подарки проекта {{$project->name}}
                    </h4>
                    <div class="slick_demo_2">
                        @foreach($project->projectGifts as $gift)
                        <div>
                            <div class="ibox-content">
                             <img src="{{asset($gift->image_link)}}" width="250" height="250" >
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
                </div>
            </div>
        </div>
        @endif
        <div class="row">
            <div class="col-lg-12">
                <h2>Сканы :</h2>
                @if($project->requisites)
                @if($project->requisites->galleries)
                @foreach($project->requisites->galleries as $gallery)
                <img width="500" height="500" src="{{asset($gallery->link_scan)}}"></a>
                @endforeach
                @endif
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 details_project_aboutProject">
                <h2>Информация о проекте:</h2>
                <div>{!! $project->description !!}</div>
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
                <a class="btn btn-info"
                href="{{route('admin_project.index')}}">Назад</a>
            </div>
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