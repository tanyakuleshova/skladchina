{{-- на входе $project --}}
<section class="project_main project_main_desc">
    <div class="container">
        <div class="project_main_top">
            <div class="row">
                <div class="col-md-2">
                    <div class="autor">
                        <a href="#" type="button" class="" data-toggle="modal" data-target="#modal-autor">
                            <img src="{{asset($project->author->avatar)}}" width="50" height="50"/>
                            <h4>{{$project->author->name.' '.$project->author->last_name}}</h4>
                        </a>
                        <p>{{trans('show_project_front.projectauthor')}}</p>
                    </div>
                </div>
                <div class="col-md-10">
                    <h3>{{$project->name}}</h3>
                    <div class="description">{{ $project->short_desc }}</div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                @include('front.project._partials.stickers',['project' => $project])
                @if($project->projectVideo)
                    @if($project->projectVideo->self_video == 0)
                    <iframe width="100%" 
                            height="450"
                            src="{{'https://www.youtube.com/embed/'.$project->projectVideo->link }}"
                            frameborder="0" allowfullscreen></iframe>
                    @else
                    <video width="100%" 
                           height="450" 
                           controls="controls"
                           poster="{{ asset($project->poster) }}">
                           <source src="{{ asset($project->projectVideo->link) }}" type='video/mp4'>
                    </video>
                    @endif
                @else
                    <img src="{{ asset($project->poster) }}" class="project-main-img"/>
                @endif
                <div class="project_main_img_text">
                    Тип проекту: <a>{{ $project->type?$project->type->name:'' }}</a>. 
                    @if($project->isActive && $project->type_id != 2)
                        Проект завершить збір коштів {{ $project->finishData }}
                    @endif
                </div>
            </div>
            <div class="col-md-4">
                <div class="project_main_info">
                    <h2>{{ number_format ($project->getActualSumm(),0,'.',' ') }}
                    @if($project->isClosedFail && $project->getFailOrderSponsoredCount())
                        <span style="color: black;"> / {{ number_format ($project->getFailOrderSumm(),0,'.',' ') }}</span>
                    @endif
                    
                    </h2>
                    <p>{{trans('show_project_front.restsumm')}} {{ number_format ($project->need_sum,0,'.',' ') }} грн</p>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="progress">
                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40"
                                 aria-valuemin="0" aria-valuemax="100" style="width: {{$project->projectProcent()}}%">
                                <span class="sr-only">{{$project->projectProcent()}}% Complete (success)</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-6 col-sm-6 col-md-6 project_main_info">
                    
                    @if($project->isActive)
                    <h3 class="downCountTimer">
                        
                        <span class="hidden">{{ $project->date_finish }}</span>
                        <span class="days"></span> <span class="days_ref"></span>

                    </h3>
                    <p>{{trans('show_project_front.projectstart')}}</p>
                    @endif
                    <div class="place">
                        <p>
                            <img src="{{asset('images/front/place.png')}}" width="15" height="15"/>
                            {{ $project->city?$project->city->name:'' }}
                        </p>
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 project_main_info">
                    @if($project->isActive)
                        <div class="project_main_spons">
                            <h3>{{ $project->getSposoredCount() }}</h3>
                            <p>{{trans('show_project_front.sponsorcount')}}</p>
                        </div>
                    @endif
                    @if($project->isClosedFail && $project->getFailOrderSponsoredCount())
                        <div class="project_main_spons">
                            <h3>{{ $project->getFailOrderSponsoredCount() }}</h3>
                            <p>{{trans('show_project_front.failsponsorcount')}}</p>
                        </div>
                    @endif
                    
                    
                    <div class="media">
                        <p>
                            <img src="{{asset('images/front/media.png')}}" width="15" height="15"/>
                            {{ $project->category?$project->category->name:'' }}
                        </p>
                    </div>
                </div>
                @if($project->isActive)
                <div class="col-xs-12 project_main_info">
                    <div class="project_main_text">
                        {{trans('show_project_front.likeidea')}}
                    </div>
                    <a href="#vote"  class="btn project_main_btn">{{trans('show_project_front.podderjat_fixed')}}</a>
                    <div class="sharing">
                        {{trans('show_project_front.share')}}
                        <div class="share42init"></div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>



<section class="project_main project_main_adaptive">
    <div class="container">
        <div class="project_main_top">
            <div class="row">
                <div class="col-md-10">
                    <h3>{{$project->name}}</h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                @if($project->projectVideo)
                    @if($project->projectVideo->self_video == 0)
                    <iframe width="100%" 
                            height="450"
                            src="{{'https://www.youtube.com/embed/'.$project->projectVideo->link }}"
                            frameborder="0" allowfullscreen></iframe>
                    @else
                    <video width="100%" 
                           height="450" 
                           controls="controls"
                           poster="{{ asset($project->poster) }}">
                           <source src="{{ asset($project->projectVideo->link) }}" type='video/mp4'>
                    </video>
                    @endif
                @else
                    <img src="{{ asset($project->poster) }}" class="project-main-img"/>
                @endif
            </div>
            <div class="col-md-4">
                <div class="project_main_info">
                    <div class="project_main_info_sum">
                        <h2>{{ $project->getActualSumm() }}</h2>
                        <p>{{trans('show_project_front.restsumm')}} {{$project->need_sum}} грн</p>
                    </div>
                    <div class="project_main_info_date">
                        @include('front.project._partials.stickers',['project' => $project])
                        <h3 class="downCountTimer">
                            
                            <span class="hidden">{{ $project->date_finish }}</span>
                            <span class="days"></span> <span>дней</span>

                        </h3>
                        <p>{{trans('show_project_front.projectstart')}}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="progress">
                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40"
                                 aria-valuemin="0" aria-valuemax="100" style="width: {{$project->projectProcent()}}%">
                                <span class="sr-only">{{$project->projectProcent()}}% Complete (success)</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-6 col-md-6 project_main_info">
                    
                    <div class="place">
                        <p>
                            <img src="{{asset('images/front/place.png')}}" width="15" height="15"/>
                            {{ $project->city?$project->city->name:'' }}
                        </p>
                    </div>
                    <div class="media">
                        <p>
                            <img src="{{asset('images/front/media.png')}}" width="15" height="15"/>
                            {{ $project->category?$project->category->name:'' }}
                        </p>
                    </div>
                    <div class="project_main_spons">
                        <h3>{{ $project->getSposoredCount() }}</h3>
                        <p>{{trans('show_project_front.sponsorcount')}}</p>
                    </div>

                    <div class="autor">
                        <img src="{{asset($project->author->avatar)}}" width="50" height="50"/>
                        <div class="autor-text-adaptive">
                            <h4>{{$project->author->name.' '.$project->author->last_name}}</h4>
                            <p>{{trans('show_project_front.projectauthor')}}</p>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 project_main_info">
                    <a href="#vote" onclick="$('a[href=\'#presents\']').trigger('click');" class="btn project_main_btn">{{trans('show_project_front.podderjat')}}</a>
                    <div class="sharing">
                        {{trans('show_project_front.share')}}
                        <div class="share42init"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="modal-autor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <img src="{{asset($project->author->avatar)}}" width="50" height="50"/>
                <p>{{trans('show_project_front.projectauthor')}}</p>
                <h4>{{ $project->author->fullName }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-7">
                        <div class="modal-autor-description">{{ $project->author->account->about_self }}</div>
                    </div>
                    <div class="col-md-5">
                        <div class="modal-autor-sidebar">
                            <img src="{{asset('images/front/miniature.png')}}" alt="">
                            @if($project->author->getSponsoredProjects()->count())
                                <span>Спонсировал проектов: {{ $project->author->getSponsoredProjects()->count() }}</span>
                            @endif
                            <p>Автор проектов: {{ $project->author->projects()->allActive()->count() }}</p>
                            
                            <img src="{{asset('images/front/place.png')}}" alt="">
                            @if($project->author->account->city_birth)
                                <span>Город: {{ $project->author->account->city_birth }}</span>
                            @endif

                            @if($project->author->account->user_site)
                            <p>Сайт: <a href="{{ $project->author->account->user_site }}" target="_blank">{{ $project->author->account->user_site }}</a></p>
                            @endif
                            
                            @if($project->author->account->social_href_facebook)
                                <i class="fa fa-facebook"></i>
                                <span>Facebook: {{ $project->author->account->social_href_facebook }}</span>
                            @endif
                            
                            @if($project->author->account->social_href_google)
                                <i class="fa fa-google-plus"></i>
                                <span>G+: {{ $project->author->account->social_href_google }}</span>
                            @endif
                            
                            @if($project->author->account->social_href_twitter)
                                <i class="fa fa-twitter"></i>
                                <span>twitter: {{ $project->author->account->social_href_twitter }}</span>
                            @endif
                            
                            @if($project->author->account->social_href_youtube)
                                <i class="fa fa-youtube"></i>
                                <span>yuotube: {{ $project->author->account->social_href_youtube }}</span>
                            @endif
                            
                            @if($project->author->account->social_href_twitter)
                                <i class="fa fa-pinterest-p"></i>
                                <span>pinterest: {{ $project->author->account->social_href_instagram }}</span>
                            @endif
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>