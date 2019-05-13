@extends('layouts.app')
@section('title','Проекты')
@section('content')
<section class="navbar_projects">
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-sm-4 col-md-2 text-center">
				<h2>{{trans('listprojectsall.sortof')}}:</h2>
			</div>
			<div class="col-xs-12 col-sm-3 col-md-6">
				<ul class="navbar_projects_list">
					<li><a class="pr_sorted" 
						{!! request('sort')=='name'?'style="background: #96ec71; color: #fff"':'' !!}
						selector="sort=name&sort_order=asc" >{{trans('listprojectsall.name')}}</a></li>
					<li><a class="pr_sorted" 
						{!! request('sort')=='popular'?'style="background: #96ec71; color: #fff"':'' !!}
						selector="sort=popular&sort_order=desc" >{{trans('listprojectsall.popular')}}</a></li>
					<li><a class="pr_sorted" 
						{!! request('sort')=='new'?'style="background: #96ec71; color: #fff"':'' !!}
						selector="sort=new&sort_order=desc" >{{trans('listprojectsall.new')}}</a></li>
					<li><a class="pr_sorted" 
						{!! request('sort')=='end'?'style="background: #96ec71; color: #fff"':'' !!}
						selector="sort=end&sort_order=asc" >{{trans('listprojectsall.endoff')}}</a></li>
				</ul>
			</div>
			<div class="col-xs-12 col-sm-5 col-md-4">
				<div class="dropdown dropdown_left">
					<select name="category_id" class="pr_selector">
						<option value="">{{trans('listprojectsall.category')}}</option>
						@foreach($categories as $c)
						<option value="{{$c->id}}" 
							{!! request('category_id')==$c->id?'selected="selected"':'' !!}
							>{{$c->cld?$c->cld->name:$c->name}}</option>
							@endforeach
					</select>
				</div>

				<div class="dropdown dropdown_right">
					<select name="city_id" class="pr_selector">
						<option value="">{{trans('listprojectsall.alltowns')}}</option>
						@foreach($cities as $c)
						<option value="{{$c->id}}" 
							{!! request('city_id')==$c->id?'selected="selected"':'' !!}
							>{{$c->cld?$c->cld->name:'---'}}</option>
							@endforeach
					</select>

				</div>
			</div>
		</div>
	</div>
</section>

<section class="list_products">
	<div class="container">
		@if(session()->has('search'))
		<div class="row">
			<div class="h2">Результаты поиска по запросу: "{{ session()->get('search') }}"
				<form  action="{{ route('projectsearch') }}" 
					   class="pull-right"
					   method="post">
					{{ csrf_field() }}
					<button class="btn" title="отменить поиск"><i class="fa fa-times" aria-hidden="true"></i></button>
					<input type="hidden" name="search" />
				</form>
			</div>
			@if($projects->isEmpty())
			<div class="h3 text-center">
				<img src="{{asset('images/front/settingsw.min.svg')}}" alt="">
				В данный момент все проекты готовятся к запуску. Осталось совсем немного…
			</div>    
			@endif
		</div>
		@endif			
		<div class="row">
			@foreach($projects as $project)
				@include('front.project.blocks.show_small_project_standart',['project'=>$project])
			@endforeach
                        
			@if($projects->isEmpty() && !session()->has('search'))
			<div class="h3 h4 text-center">
				Таких проектов ещё нет… Прекрасная возможность стать одним из первых!
				<img src="{{asset('images/front/arrow_down.svg')}}" alt="">
			</div>
                        @endif
                        
		</div>
		
		<div class="row">
			<div class="col-md-12 text-center">
				{{ $projects->links() }}
			</div>
		</div>			
	</div>
</section>

<section class="start_project">
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-md-8">
				{!!trans('listprojectsall.startproject')!!}
			</div>
			<div class="col-xs-12 col-md-4">
				<div class="start_project_btn_wrap">
					<a href="{{ route('project.create') }}" class="btn">{{trans('listprojectsall.startbtn')}}</a>
				</div>
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
	});


	var gets = (function() {
		var a = window.location.search;
		a = a.substring(1).split("&");
		return mypars(a);
	})();

	function mypars(in_obj){
		var ret_obj = new Object();
		for (var i = 0; i < in_obj.length; i++) {
			var c = in_obj[i].split("=");
			ret_obj[c[0]] = c[1];
		}
		return ret_obj;
	}

	function sort_select_page(at){
		var old = $.extend( {}, gets );
		var obj = mypars( at.split("&") );

		for (var key in obj) {
			if (obj[key] === undefined || obj[key] == '' || obj[key] == null) {
				delete obj[key];
				delete old[key];
			}

		}

		window.location.search = $.param( $.extend({}, old, obj) );
	}




	$('.pr_sorted').on('click',function(){
		event.preventDefault();
		var se = $(this).attr('selector');
                console.log('.pr_sorted',se);
		sort_select_page(se);
	});




	$('.pr_selector').on('change',function(){
		event.preventDefault();
		var name = $(this).attr('name');
		var valu = $(this).val();
                console.log('.pr_selector',name + '=' + valu);
		sort_select_page(name + '=' + valu);
	});



//                                    <div class="dropdown dropdown_right">
//                                        <button class="btn dropdown-toggle" type="button" data-toggle="dropdown">{{trans('listprojectsall.town')}}
//                                                <i class="fa fa-caret-down"></i>
//                                        </button>
//                                        <ul class="dropdown-menu">
//                                                <li><a class="pr_selector" selector="city_id=">Все</a></li>
//                                            @foreach($cities as $c)
//                                                <li><a class="pr_selector" 
//                                                       {!! request('city_id')==$c->id?'style="background: #96ec71;"':'' !!}
//                                                       selector="city_id={{$c->id}}">{{$c->description?$c->description->name:'---'}}</a></li>
//                                            @endforeach    
//                                        </ul>
//
//                                    </div>


});

</script>

@endsection

