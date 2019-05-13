@foreach($projects as $project)
<div class="col-xs-12">
	<div class="user-project-wrap">
		<div class="user-project-main">
			<div class="user-project-main-left">
				@include('front.project._partials.stickers',['project'=>$project])
				@if($project->isActive)
					<img src="{{ asset($project->poster) }}"/>
				@else
					<img src="{{ asset($project->poster) }}"/>
				@endif
				<div class="description">
					@if($project->isActive)
						<h3>{{$project->name}}</h3>
					@else
						<h3>{{$project->name}}</h3>
					@endif
				</div>
			</div>
			<div class="user-project-main-right">
				<div class="description">
					<p>{{$project->short_desc}}</p>
					<span>Автор:
						<a>{{$project->author->name.' '.$project->author->last_name}}</a>
					</span>
					<div class="media">
						<p>
							<img src="{{asset('images/front/media.png')}}" width="15" height="15"/>
							{{ $project->category?$project->category->name:' - ' }}
						</p>
					</div>
					<div class="place">
						<p>
							<img src="{{asset('images/front/place.png')}}" width="15" height="15" />
							{{ $project->city?$project->city->name:' - ' }}
						</p>
					</div>
				</div>

				<div class="stats">
					<div class="progress">
						<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: {{$project->projectProcent()}}%">
							<span class="sr-only">{{$project->projectProcent()}}% Complete (success)</span>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-4 col-md-4 product_statistics">
							<div class="chose_number">
								{{round($project->projectProcent(),2)}}%
							</div>
							<div class="chose_description">
								{{trans('listprojectsall.progress')}}
							</div>
						</div>
						<div class="col-xs-4 col-md-4 product_statistics product_statistics_center">
							<div class="chose_number">
								{{ number_format ($project->getActualSumm(),0,'.',' ') }} грн
							</div>
							<div class="chose_description">
								{{trans('listprojectsall.sobral')}}
							</div>
						</div>
						<div class="col-xs-4 col-md-4 product_statistics">
							<div class="chose_number">
								{{ $project->getSposoredCount() }}
							</div>
							<div class="chose_description">
								спонсоров
							</div>
						</div>

						@if($project->isActive)
						<div class="col-xs-12 col-md-12 product_statistics product-statistics-timer">
							<div class="chose_number downCountTimer">
								<img src="{{asset('images/front/clock_icon.png')}}" />
								{{trans('listprojectsall.ostalos')}}:
								<span class="hidden">{{ $project->date_finish }}</span>
								<span class="days"></span>дней
								<span class="hours"></span>часов
								<span class="minutes"></span>минут
							</div>
						</div>
						@elseif($project->isAllClosed)
						<div class="col-xs-12 col-md-12 product_statistics product-statistics-timer">
							{{ $project->statusName }}
						</div>
						@endif

					</div>
				</div>
			</div>
		</div>
		<div class="user-project-info">
			<h2>Ваш менеджер проекта</h2>
			<div class="create_finish_manager">
				<img src="{{ $project->admin->avatar }}">
			</div>
			<h4>{{ $project->admin->fullName }}</h4>
			<div class="mail">
				<p>
					<img src="{{asset('images/front/mail.png')}}" height="12" width="15">
					{{ $project->admin?$project->admin->email:'...' }}
				</p>
			</div>
			<div class="phone">
				<p>
					<i class="fa fa-phone-square" aria-hidden="true" style="color: lightskyblue;"></i>
					&nbsp;&nbsp;&nbsp;&nbsp;{{ ($project->admin && $project->admin->account)?$project->admin->account->contact_phone:'...'}}
				</p>
			</div>
			
			<div class="user-project-btn">
                <form class="pull-left" action="{{route('project.destroy',$project->id)}}" method="post">
                        {{ method_field('DELETE') }}
                        {{csrf_field()}}
                    <button type="submit" 
                                title="Удалить проект"
                                onclick="return checkButtonSwalDelete(this,'warning','Удалить этот проект ?');"
                                class="btn btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i> {{trans('createproject.delproject')}}</button>
                </form>
                                
				<a class="btn pull-right" title="Редактировать проект" href="{{route('edit_project',$project->id)}}">Редактировать</a>
			</div>
		</div>
	</div>
</div>




@endforeach
