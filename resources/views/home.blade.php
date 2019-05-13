@extends('layouts.app')
@section('title',trans('meta.home_title'))
@section('meta-description',trans('meta.home_desc'))
@section('content')
<!-- БАННЕР НА ГЛАВНОЙ -->
<section class="bg_light">
	<div class="container">
		<div class="banner_main">
			<div class="row">
				<div class="col-xs-12 col-md-8">
					<h1>
						<span class="greeny">{{trans('home.crout')}}</span> 
						{{trans('home.in_ukr')}}
						<br>
						{{trans('home.grom_fin')}}
					</h1>
				<!-- <div class="uppercase">
					{{trans('home.banner_message')}}
				</div>
				{{trans('home.more_details')}}
				<div> -->
					<a href="{{route('manual')}}" class="btn">{{trans('home.more')}}
						<i class="fa fa-angle-double-right"></i>
					</a>
				</div>
			</div>
		</div>
	</div>
<!-- </div> -->
</section>
@if($main_project)
    @include('front.project.blocks.home_main_project', ['project' => $main_project])
@endif
<!-- БАННЕР -->
<section class="banner_home_wrap">
	<div class="container">
		<div class="banner_home">
			<div class="banner_home_rocket"></div>
			<div class="row">
                            <div class="col-xs-12 col-md-7 col-md-push-3">
                                <div class="banner_home_desc">
                                    {!!trans('home.bannermainheader')!!}
                                </div>
                            </div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-md-7 col-md-push-3">
					<div class="banner_home_desc">
                        <!-- {{trans('home.bannermaincenter')}} -->
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12 col-md-9 col-md-push-3">
					<div class="banner_home_text">
						<!-- {{trans('home.bannermainbottom')}} -->
					</div>
				</div>
			</div>
			<a href="{{route('project.create')}}" class="btn banner_home_btn">Запуск<i class="fa fa-angle-double-right"></i></a>
			<div class="banner_home_treangle"></div>
		</div>
	</div>
</section>

@if(!$popular_projects->isEmpty())
<!-- ПОПУЛЯРНЫЕ ПРОЕКТЫ -->
<section class="popular">
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<h2>
					<span class="greeny">{{trans('home.popular')}}</span> 
					{{trans('home.projects')}}
				</h2>
			</div>
			<div class="col-md-6 main_view_all">
				<a href="{{route('projects')}}">
					<img src="{{asset('images/front/view.png')}}" height="10" width="16"/>{{trans('home.show_all')}}
				</a>
			</div>
		</div>
		<div class="row">
			@foreach($popular_projects as $popular_project)
                            @include('front.project.blocks.show_small_project_standart',['project'=>$popular_project])
			@endforeach
		</div>
	</div>
</section>
@endif

@if(!$new_projects->isEmpty())
<!-- НОВЫЕ ПРОЕКТЫ -->
<section class="new">
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<h2>
					<span class="greeny">{{trans('home.new_project')}}</span> 
					{{trans('home.projects')}}
				</h2>
			</div>
			<div class="col-md-6 main_view_all">
				<a href="{{route('projects')}}">
					<img src="{{asset('images/front/view.png')}}" height="10" width="16"/>
					{{trans('home.show_all')}}
				</a>
			</div>
		</div>
		<div class="row">
			@foreach($new_projects as $new_project)
                            @include('front.project.blocks.show_small_project_standart',['project'=>$new_project])
			@endforeach
		</div>
	</div>
</section>
@endif
@if(!$all_home_projects->isEmpty())
<!-- НОВЫЕ ПРОЕКТЫ -->
<section class="new">
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<h2>
					<span class="greeny">{{trans('home.closed_project')}}</span> 
					{{trans('home.projects')}}
				</h2>
			</div>
			<div class="col-md-6 main_view_all">
				<a href="{{route('projects')}}">
					<img src="{{asset('images/front/view.png')}}" height="10" width="16"/>
					{{trans('home.show_all')}}
				</a>
			</div>
		</div>
		<div class="row">
			@foreach($all_home_projects as $new_project)
                            @include('front.project.blocks.show_small_project_standart',['project'=>$new_project])
			@endforeach
		</div>
	</div>
</section>
@endif

<!-- БЛОК О ПРОЕКТЕ -->
<section class="about">
	<div class="container">
		<h4 class="text-center">{{trans('home.about_message_one')}} 
			<br>
			{{trans('home.about_message_two')}}
		</h4>
		<h5 class="text-center">{{trans('home.about_message_third')}}</h5>
		<div class="row">
			<div class="col-xs-12 col-sm-6 col-md-3">
				<div class="main_about_img">
					<img src="{{asset('images/front/main_about_img1.png')}}" height="74" width="61"/>
				</div>
				<h3>{{trans('home.city_project')}}</h3>
				<div class="description">
					{{trans('home.city_project_message')}}
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-3">
				<div class="main_about_img">
					<img src="{{asset('images/front/main_about_img2.png')}}" height="72" width="64"/>
				</div>
				<h3>{{trans('home.art_project')}}</h3>
				<div class="description">
					{{trans('home.art_project_message')}}
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-3">
				<div class="main_about_img">
					<img src="{{asset('images/front/main_about_img3.png')}}" height="79" width="79"/>
				</div>
				<h3>{{trans('home.bisness_project')}}</h3>
				<div class="description">
					{{trans('home.bisness_project_message')}}
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-3">
				<div class="main_about_img">
					<img src="{{asset('images/front/main_about_img4.png')}}" height="79" width="79"/>
				</div>
				<h3>{{trans('home.science_project')}}</h3>
				<div class="description">
					{{trans('home.science_project_message')}}
				</div>
			</div>
		</div>
	</div>
</section>

<!-- БЛОК С КНОПКОЙ -->
<section class="make-step">
	<div class="container">
		<div class="row">
			<div class="col-md-8">
				<h2>{{trans('home.banner_two_message_1')}} <span class="greeny">{{trans('home.banner_two_message_2')}}</span></h2>
			</div>
			<div class="col-md-4 text-right">
				<a href="{{route('project.create')}}" class="btn">{{trans('nav_front.start_project')}}</a>
			</div>
		</div>
	</div>
</section>

@endsection
@section('script')
<script type="text/javascript" src="{{asset('js/jquery.downCount.js')}}"></script>
<script>
jQuery('document').ready(function($){
	$('.downCountTimer').each(function(){
		var deadline = $.trim($(this).find('.hidden').html());
		if (deadline == '') return;

		$(this).downCount({date: deadline,});      

		console.log(deadline);         
		console.log(this);

	});


});

</script>

@endsection
