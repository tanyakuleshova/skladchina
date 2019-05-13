@extends('layouts.app')
@section('content')
    <div class="wrap">
        <section class="profile_main">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <h2 class="caption">профіль</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-sm-7 col-md-8 profile_main_photo">
                        
                        @if(Session::has('success_message'))
                            <div class="container">
                                <div class="row">
                                    <div class="alert alert-success">{{Session::get('success_message')}}</div>
                                </div>
                            </div>
                        @endif
                        @if(Session::has('warning_message'))
                            <div class="container">
                                <div class="row">
                                    <div class="alert alert-warning">{{Session::get('warning_message')}}</div>
                                </div>
                            </div>
                        @endif
                        <div class="profile_main_img">
                                <img src="{{ asset( Auth::user()->avatar) }}" alt="avatar">
                        </div>
                        <h3>{{Auth::user()->name}}</h3>
                        <p>{{Auth::user()->account->city_birth}}</p>
                    </div>
                    <div class="col-xs-6 col-sm-5 col-md-4 profile_main_info">
                        <p>Баланс: <span>{{ Auth::user()->getMyBalance() }} грн.</span></p>
                        <a href="{{ route('mybalance.index') }}">
                            <button>{{trans('user_profile.addmoneybtn')}}</button>
                        </a>
                    </div>
                </div>
            </div>
        </section>
        <section class="profile_tabs">
            <div class="wide-border">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-md-12">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active">
                                    <a href="#tab1" aria-controls="home" role="tab" data-toggle="tab" class="profile_tabs_text">{{trans('user_profile.supportproject')}}</a>
                                    <a href="#tab1" aria-controls="home" role="tab" data-toggle="tab" class="profile_tabs_img"><img src="{{asset('images/front/profile_tabs_img_1.png')}}" alt=""></a>
                                </li>
                                <li role="presentation">
                                    <a href="#tab2" aria-controls="profile" role="tab" data-toggle="tab" class="profile_tabs_text">{{trans('user_profile.myprojects')}}</a>
                                    <a href="#tab2" aria-controls="profile" role="tab" data-toggle="tab" class="profile_tabs_img"><img src="{{asset('images/front/profile_tabs_img_2.png')}}" alt=""></a>
                                </li>
                                <li role="presentation">
                                    <a href="#tab3" aria-controls="messages" role="tab" data-toggle="tab" class="profile_tabs_text">{{trans('user_profile.mypresents')}}</a>
                                    <a href="#tab3" aria-controls="messages" role="tab" data-toggle="tab" class="profile_tabs_img"><img src="{{asset('images/front/profile_tabs_img_3.png')}}" alt=""></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="row">
                    <!-- Tab panes -->
                    <div class="tab-content">

                        <div role="tabpanel" class="tab-pane active" id="tab1">
                            @if(Auth::user())
                                @foreach(Auth::user()->getSponsoredProjects() as $project)
                                    <div class="col-xs-12 col-sm-6 col-md-4">
                                        @include('front.project.blocks.show_small_project_sponsored',['project'=>$project])
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <!-- Мои проекты  -->
                        <div role="tabpanel" class="tab-pane" id="tab2">
                            @foreach(Auth::user()->projects as $project)
                                <div class="col-xs-12 col-sm-6 col-md-4">
                                    <div class="product_wrap">
                                        @if($project->poster_link)
                                        <a href="#">
                                            <img src="{{asset($project->poster_link)}}"/>
                                        </a>
                                        @else
                                        <a href="#">
                                            <img src="product1.jpg"/>
                                        </a>
                                        @endif
                                        <div class="product_wrap_info product_wrap_my_project">
                                            <div class="description">
                                                <h3>{{$project->name}}</h3>
                                                <p>{{$project->short_desc}}</p>
                                                <span>Автор:<a
                                                            href=""> {{Auth::user()->name.' '.Auth::user()->last_name}}</a></span>
                                                <div class="media">
                                                    @if($project->categoryProject)
                                                        <p>
                                                            <img src="{{asset('images/front/media.png')}}" width="15" height="15"/>
                                                            {{$project->categoryProject->name}}
                                                        </p>
                                                    @endif
                                                </div>
                                                @if($project->location)
                                                    <div class="place">
                                                        <p>
                                                            <img src="{{asset('images/front/place.png')}}" width="15" height="15"/>
                                                            {{$project->location}}
                                                        </p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="row my_project">
                                                @if($project->mod_status == 0)
                                                    <div>
                                                        <a class="btn" href="{{route('edit_project',$project->id)}}">Редактировать</a>
                                                    </div>
                                                @endif
                                                @if($project->mod_status == 1 )
                                                    <div>
                                                        <button class="btn" disabled="">{{trans('user_profile.moderation')}}</button>
                                                    </div>
                                                @endif
                                                @if($project->mod_status == 2 )
                                                    <div>
                                                        <button class="btn" disabled="">{{trans('user_profile.active')}}</button>
                                                    </div>
                                                @endif
                                                @if($project->mod_status == 3 )
                                                    <div>
                                                        <button class="btn" disabled="">{{trans('user_profile.endproject')}}</button>
                                                    </div>
                                                @endif
                                                <form class="buttons_project" action="" method="post">
                                                    {{csrf_field()}}
                                                    <button type="submit" class="project_del">
                                                        <img src="{{asset('images/front/create_delete_btn.png')}}" height="12" width="12" alt="">{{trans('createproject.deleteproj')}}
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <!-- ////////// -->
                        <div role="tabpanel" class="tab-pane" id="tab3">
                            @if(Auth::user()->gifts)
                                @foreach(Auth::user()->gifts as $gift)
                                    <div class="col-xs-6 col-md-4">
                                        <div class="rewards">
                                            <section>
                                                <img src="{{asset($gift->gift->image)}}"/> 
                                                <div class="rewards_wrap">
                                                    <h3>{{$gift->gift->need_sum}}</h3>
                                                    {!!$gift->gift->description!!}
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div>{{trans('user_profile.restpresent')}}: {{$gift->gift->limit - $gift->gift->getUserGiftsCount()}} / {{$gift->gift->limit}}</div>
                                                            <div>{{trans('user_profile.reciveprestnt')}}: {{$gift->gift->delivery_date}}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </section>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('script')
<script type="text/javascript" src="{{asset('js/jquery.downCount.js')}}"></script>
<script>
jQuery('document').ready(function($){
	$('.downCountTimer').each(function(){
		var deadline = $.trim($(this).find('.hidden').html());
		if (deadline == '') return;
		$(this).downCount({date: deadline,});      
	});
});
</script>
@endsection

