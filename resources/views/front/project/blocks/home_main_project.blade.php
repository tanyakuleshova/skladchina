{{-- на входе объект $project --}}
<!-- ВЫБОР РЕДАКЦИИ -->
<section>
    <div class="container">
        <h2>
            <span class="icon_chose"></span>
            <span class="greeny">{{trans('home.choise')}}</span> 
            {{trans('home.redak')}}
        </h2>
        <div class="chose_item">
            <div class="chose_left">
                <a href="{{route('show_project',[$project->id,$project->SEO])}}">
                    <img src="{{ asset($project->poster) }}"/>
                </a>
            </div>
            <div class="chose_right">
                <a class="chose_title" href="{{route('show_project',[$project->id,$project->SEO])}}">
                    {{$project->name}}
                </a>
                <div class="chose_description">
                    {{$project->short_desc}}
                </div>
                <div class="autor">
                    Автор проекту:
                    <a href="#">
                        {{$project->author->name.' '.$project->author->last_name}}
                    </a>
                </div>
                <div class="progress">
                    <div class="progress-bar progress-bar-success" 
                         role="progressbar" 
                         aria-valuenow="40" 
                         aria-valuemin="0" 
                         aria-valuemax="100" 
                         style="width: {{$project->projectProcent()}}%">
                        <span class="sr-only">{{$project->projectProcent()}}% Complete (success)</span>
                    </div>
                </div>
                <div class="choise_stats">
                    <div class="row">
                        <div class="col-xs-4 col-md-4">
                            <div class="chose_number">
                                {{ round($project->projectProcent(),2) }}%
                            </div>
                            <div class="chose_description">
                                {{trans('home.progres')}}
                            </div>
                        </div>
                        <div class="col-xs-4 col-md-4">
                            <div class="chose_number">
                                {{ number_format ($project->getActualSumm(),0,'.',' ') }} грн
                            </div>
                            <div class="chose_description">
                                {{trans('home.current_sum')}}
                            </div>
                        </div>
                        <div class="col-xs-4 col-md-4">
                            <div class="chose_number">
                                {{ $project->getSposoredCount() }}
                            </div>
                            <div class="chose_description">
                                спонсоров
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="media">
                            <p>
                                <img src="{{asset('images/front/media.png')}}" />
                                {{ $project->category?$project->category->name:'' }}
                            </p>
                        </div>
                        <div class="place">
                            <p>
                                <img src="{{asset('images/front/place.png')}}" />
                                {{ $project->city?$project->city->name:'' }}
                            </p>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="chose-btn-wrap">
                            <a href="{{route('project.show',$project->id)}}#vote" class="btn">
                                {{trans('home.suport')}}
                            </a>
                        </div>
                    </div>
                    
                    <div class="col-xs-12 col-md-12 product_statistics product-statistics-timer">
                        @if($project->isActive)
                        <div class="chose_number downCountTimer">
                            <img src="{{asset('images/front/clock_icon.png')}}" />
                            {{trans('listprojectsall.ostalos')}}:
                            <span class="hidden">{{  $project->date_finish }}</span>
                            <span class="days"></span><span class="days_ref"></span>
                            <span class="hours"></span><span class="hours_ref"></span>
                            <span class="minutes"></span><span class="minutes_ref"></span>
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
    </div>
</section>
<!-- / ВЫБОР РЕДАКЦИИ -->