{{-- на входе обхект $project --}}

<div class="product_wrap">
        <a href="{{route('show_project',$project->id)}}">
                <img src="{{asset($project->poster_link)}}"/>
        </a>
        <div class="product_wrap_info">
                <div class="description">
                        <a href="{{route('show_project',$project->id)}}"> 
                                <h3>{{$project->name}}</h3>
                        </a>
                        <p>{{$project->short_desc}}</p>
                        <span>Автор:
                                <a href="">{{$project->author->name.' '.$project->author->last_name}}</a>
                        </span>
                        <div class="media">
                                <p>
                                        <img src="{{asset('images/front/media.png')}}" width="15" height="15"/>
                                        {{ ($project->category && $project->category->cld)?$project->category->cld->name:' - '}}
                                </p>
                        </div>
                        <div class="place">
                                <p>
                                    <img src="{{asset('images/front/place.png')}}" width="15" height="15" />
                                    {{ ($project->city && $project->city->cld)?$project->city->cld->name:' - ' }}
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
                                                {{$project->getActualSumm()}} грн
                                        </div>
                                        <div class="chose_description">
                                                {{trans('listprojectsall.sobral')}}
                                        </div>
                                </div>
                                <div class="col-xs-4 col-md-4 product_statistics">
                                        <div class="chose_number downCountTimer">
                                                @if (\Carbon\Carbon::now()>=$project->date_finish)
                                                проект завершен
                                                @else
                                                        <span class="hidden">{{ $project->date_finish }}</span>
                                                        <span class="days"></span>:<span class="hours"></span>:<span class="minutes"></span>
                                                        <p>{{trans('listprojectsall.ostalos')}}</p>
                                                @endif
                                        </div>
                                </div>
                        </div>
                </div>
        </div>
</div>