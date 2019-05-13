@foreach($projects as $project)

<div class="col-xs-12">
	<div class="user-project-wrap">
		<div class="user-project-main">
			<div class="user-project-main-left">
				@if($project->isActive)
				<a href="{{route('show_project',[$project->id,$project->SEO])}}">
					<img src="{{ asset($project->poster) }}"/>
				</a>
				@else
				<a href="{{route('project.show',$project->id)}}">
					<img src="{{ asset($project->poster) }}"/>
				</a>
				@endif
				<div class="description">
					@if($project->isActive)
					<a href="{{route('show_project',[$project->id,$project->SEO])}}"> 
						<h3>{{$project->name}}</h3>
					</a>
					@else
					<a href="{{route('project.show',$project->id)}}"> 
						<h3>{{$project->name}}</h3>
					</a>
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

						@if($project->isActive && $project->finishData)
                                                    <div class="col-xs-12 col-md-12 product_statistics product-statistics-timer">
                                                            <div class="chose_number downCountTimer">
                                                                    <img src="{{asset('images/front/clock_icon.png')}}" />
                                                                    {{trans('listprojectsall.ostalos')}}:
                                                                    <span class="hidden">{{ $project->date_finish }}</span>
                                                                    <span class="days"></span><span class="days_ref"></span>
                                                                    <span class="hours"></span><span class="hours_ref"></span>
                                                                    <span class="minutes"></span><span class="minutes_ref"></span>
                                                            </div>
                                                    </div>
                                                @elseif($project->isActive)
                                                    <div class="col-xs-12 col-md-12 product_statistics product-statistics-timer">
                                                        {{ $project->type?$project->type->name:'' }}
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
			<div class="ibox-content">
				<table class="table">
					<thead>
						<tr>
                                                    <th></th>
                                                    <th>Комментарии</th>
                                                    <th>Олачено</th>
                                                    <th>Просмотров</th>
						</tr>
					</thead>
					<tbody>   
						<tr>
                                                    <td>Активность</td>
                                                    <td data-label="Комментарии:">{{ $project->comments()->count() }}</td>
                                                    <td data-label="Оплачено подарков:">{{ $project->projectUserGifts->count() }}</td>
                                                    <td data-label="Просмотров:">{{ $project->viewed }}</td>
						</tr>
					</tbody>
				</table>
				<table class="table">
					<thead>
						<tr>
							<th></th>
							<th>Всего</th>
							<th>Модерация</th>
							<th>Доступно</th>
							<th></th>
						</tr>
					</thead>
					<tbody>   
						<tr>
							<td>Обновления</td>
							<td data-label="Всего:">{{ $project->pupdates->count() }}</td>
							<td data-label="Выдано:">{{ $project->pupdates()->pending()->count() }}</td>
							<td data-label="Осталось:">{{ $project->pupdates()->approved()->count() }}</td>
							<td>
								<!--a href="#" class="table-present-btn"><i class="fa fa-plus"></i></a -->
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="user-project-btn">
				<a href="{{ route('projectup.index')}}?project_id={{ $project->id }}" class="btn pull-right" title="Обновления проекта">Обновления</a>
			</div>
		</div>
	</div>
</div>

@endforeach
