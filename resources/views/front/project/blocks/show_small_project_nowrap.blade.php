{{-- на входе обхект $project --}}

    <a href="{{route('show_project',[$project->id,$project->SEO])}}">
        <img src="{{ asset($project->poster) }}"/>
    </a>
@if($project->isActive)
@endif

<div class="product_wrap_info">
    <div class="description">
        
            <a href="{{route('show_project',[$project->id,$project->SEO])}}"> 
                <h3>{{$project->name}}</h3>
            </a>
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

                </div>
            @elseif($project->isAllClosed)
            <hr>
                <div class="col-xs-12 col-md-12 product_statistics product-statistics-timer">
                    {{ $project->statusName }}
                </div>
            @endif
            
        </div>
    </div>
    
</div>
