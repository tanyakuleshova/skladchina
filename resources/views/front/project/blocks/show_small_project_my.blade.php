{{-- на входе обхект $project --}}
<div class="col-xs-12 col-sm-6 col-md-4">
<div class="my_project_wrap">
	<div class="product_wrap">
		@include('front.project.blocks.show_small_project_nowrap',['project'=>$project])

		<div class="my_project">		
			<!-- <div class="col-md-12">
				@foreach($project->projectGifts as $gift)
				<div>{{trans('user_profile.restpresent')}}: {{$gift->limit - $gift->getUserGiftsCount()}} / {{$gift->limit}}</div>
				<div>{{trans('user_profile.reciveprestnt')}}: {{$gift->delivery_date}}</div>
				@endforeach
			</div>

			@if($project->pupdates()->approved()->count())
			<div class="col-md-12">
				<p>Утверждённых обновлений: {{ $project->pupdates()->approved()->count() }}</p>
			</div>
			@endif  -->

			@if($project->mod_status == 0)
			<div>
				<a class="btn" href="{{route('edit_project',$project->id)}}">Редактировать</a>
			</div>
			<form class="buttons_project" action="{{route('myprojects.destroy',$project->id)}}" method="post">
				{{csrf_field()}}
				<button type="submit" class="project_del">
					<img src="{{asset('images/front/create_delete_btn.png')}}" height="12" width="12" alt="">{{trans('createproject.deleteproj')}}
				</button>
			</form>
			@endif
			@if($project->mod_status == 1 )
			<div>
				<button class="btn" disabled="">{{trans('user_profile.moderation')}}</button>
			</div>
			@endif
			@if($project->mod_status == 2 )
			<div>
				<button class="btn" disabled="">{{trans('user_profile.active')}}</button>
				<a href="{{ route('projectup.index')}}?project_id={{ $project->id }}" class="btn pull-right" title="Обновления проекта">Обновления</a>
			</div>
			@endif
			@if($project->mod_status == 3 )
			<div>
				<button class="btn" disabled="">{{trans('user_profile.endproject')}}</button>
			</div>
			@endif
		</div>
	</div>
</div>
</div>