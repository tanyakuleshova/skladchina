@extends('layouts.app')
@section('content')
    <section class="list_products">
        <h1 class="text-center">{{trans('user_profile.userprojects')}} {{Auth::user()->name}}</h1>
        <div class="container">
            <div class="row">
                @foreach($projects as $project)
                    <div class="col-xs-12 col-sm-6 col-md-4">
                        <div class="product_wrap">
                            <a href="{{route('project.show',$project->id)}}">
                                <img src="{{asset($project->poster_link)}}"/>
                            </a>
                            <div class="product_wrap_info">
                                <div class="description">
                                    <a href="{{route('project.show',$project->id)}}"> <h3>{{$project->name}}</h3></a>
                                    <p>{{$project->short_desc}}</p>
                                    <span>Автор:<a href=""> {{$project->author->name.' '.$project->author->last_name}}</a></span>
                                    <div class="media">
                                        <p>
                                            <img src="{{asset('images/front/media.png')}}" width="15" height="15"/>
                                            {{$project->categoryProject->name}}
                                        </p>
                                    </div>
                                    <div class="place">
                                        <p>
                                            <img src="{{asset('images/front/place.png')}}" width="15" height="15" />
                                            {{$project->location}}
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
                                            <h4>{{round($project->projectProcent(),2)}}%</h4>
                                            <p>{{trans('user_profile.progress')}}</p>
                                        </div>
                                        <div class="col-xs-4 col-md-4 product_statistics product_statistics_center">
                                            <h4>{{$project->getActualSumm()}} грн</h4>
                                            <p>{{trans('user_profile.mymoneyproject')}}</p>
                                        </div>
                                        <div class="col-xs-4 col-md-4 product_statistics">
                                            <h4>16 годин</h4>
                                            <p>{{trans('user_profile.resttime')}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection