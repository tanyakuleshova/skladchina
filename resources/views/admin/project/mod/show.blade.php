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

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Основное</a></li>
                        <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Описание</a></li>
                        <li role="presentation"><a href="#gifts" aria-controls="gifts" role="tab" data-toggle="tab">Подарки</a></li>
                        <li role="presentation"><a href="#requisites" aria-controls="requisites" role="tab" data-toggle="tab">Реквизиты</a></li>
                    </ul>

                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="home">
                            <div class="row">
                                @include('admin.project.blocks.main',['project'=>$project])
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="profile">
                            <div class="row">
                                {!! $project->description !!}
                            </div>
                        </div>

                        <div role="tabpanel" class="tab-pane" id="gifts">
                            <div class="row">
                                @if($project->project_giftt_type == 1)
                                @include('admin.project.blocks.gifts',['project'=>$project])
                                @endif
                            </div>
                        </div>   
                        <div role="tabpanel" class="tab-pane" id="requisites">
                            <div class="row">
                                @include('admin.project.blocks.requisites',['project'=>$project])
                            </div>

                        </div> 
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">
            <a class="btn btn-info pull-left" href="{{route('a_modprojects.index')}}">К списку проектов</a>
            <form action="{{route('a_modprojects.update',$project->id)}}" method="post">
                {{csrf_field()}}
                {{ method_field('PUT') }}
                <input type="hidden" name="action" value="approved">
                <button class="btn btn-danger pull-right">Допустить проект к размещению на площадке</button>
            </form>            
        </div>
        <div><br/><br/><br/><br/><br/><br/><br/></div>
        <div class="col-lg-10 col-lg-offset-1">
            <form action="{{route('a_modprojects.update',$project->id)}}" method="post">
                {{csrf_field()}}
                {{ method_field('PUT') }}
                <input type="hidden" name="action" value="rejected">
                @if(Auth::guard('admin')->check() && Auth::guard('admin')->user()->isAdmin)       
                <div class="form-group">
                    <label for="admin_id" class="control-label">Администратор</label>
                    @if($admins->count() == 1)
                    <input type="hidden" name="admin_id" value="{{ $admins->first()->id }}">
                    <p>{{ $admins->first()->fullName }}</p>
                    @else
                    <select class="form-control" name="admin_id">
                        @foreach($admins as $admin)
                        <option value="{{ $admin->id }}"
                                @if($admin->id == $project->admin_id) selected @endif>{{ $admin->fullName }}</option>
                        @endforeach
                    </select>
                    @endif
                </div>
                @else
                <div class="form-group">
                    <label for="admin_id" class="control-label">Администратор</label>
                    <p>{{ $project->admin->fullName }}</p>
                </div>
                @endif


                <label class="control-label" for="location">Укажите причину доработки</label>
                <input class="form-control" type="text" name="location" value="{{ $project->location }}">
                <button class="btn btn-success">Отправить на доработку</button>
            </form> 
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