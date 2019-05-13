@extends('layouts.app')

@section('title','Поддержаные проекты')

@section('content')


<section class="list_products support-wrap">
    <h1 class="text-center">Поддержанные проекты</h1>
    <div class="container">
        <div class="row">
            @foreach($projects as $project)

            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <a href="{{ route('project.show',$project->id) }}">
                            <img src="{{ asset($project->poster) }}"/>
                        </a>
                    </div>

                    <div class="col-md-4 description">
                        <a href="{{route('project.show',$project->id)}}"><h3>{{ $project->name }}</h3></a>
                        <p>{{ $project->short_desc }}</p>
                        <span>Автор:<a href=""> {{ $project->author->fullName }}</a></span>

                    </div>
                    <div class="col-md-4 stats">
                        <div class="media">
                            <p>
                                <img src="{{asset('images/front/media.png')}}" width="15" height="15"/>
                                {{ $project->category?$project->category->name:'' }}
                            </p>
                        </div>
                        <div class="place">
                            <p>
                                <img src="{{asset('images/front/place.png')}}" width="15" height="15" />
                                {{ $project->city?$project->city->name:'' }}
                            </p>
                        </div>
                        <div class="progress">
                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: {{$project->projectProcent()}}%">
                                <span class="sr-only">{{ $project->projectProcent() }}% Complete (success)</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-4 col-md-4 product_statistics">
                                <h4>{{ round($project->projectProcent(),2) }}%</h4>
                                <p>{{trans('user_profile.progress')}}</p>
                            </div>
                            <div class="col-xs-4 col-md-4 product_statistics product_statistics_center">
                                <h4>{{ number_format ($project->getActualSumm(),0,'.',' ') }} грн</h4>
                                <p>{{trans('user_profile.mymoneyproject')}}</p>
                            </div>
                            <div class="col-xs-4 col-md-4 product_statistics">
                                @if($project->isActive)
                                    <h4>{{ $project->getFinishData(true) }} годин</h4>
                                    <p>{{trans('user_profile.resttime')}}</p>
                                @elseif($project->isAllClosed)
                                    {{ $project->statusName }}
                                @endif



                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="support-information">
                                    Вы поддержали на : {{ number_format ($project->getUserSumm(Auth::id()),0,'.',' ') }} грн.
                                    @if($project->projectUserGifts->count())
                                    <br> Выбрано наград {{ $project->getUserGifts(Auth::id())->sum('quantity') }} шт.
                                    @else
                                    <br> Безвозмездно.
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        @if($project->isActive)
                        <div class="row">
                            <div class="col-md-12">
                                <form action="{{route('support_project.destroy',$project->id)}}" method="post" class="form-refuse">
                                    {{csrf_field()}}
                                    {{ method_field('DELETE') }}
                                    <button type="submit" 
                                            onclick="return checkDeleteText(' вашу поддержку этого проекта')"
                                            class="btn">Отказаться от поддержки проекта</button>
                                </form>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-md-12"><hr></div>
            @endforeach
        </div>
        <div class="row">
            <div class="col-md-12">{{ $projects->links() }}</div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="support-wrap-btn">
                    <a href="{{ route('mybalance.index') }}" class="btn btn-info">Назад, Мои финансы</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
