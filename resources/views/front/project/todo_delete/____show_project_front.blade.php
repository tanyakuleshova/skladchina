@extends('layouts.app')
@section('content')
    <section class="project_main">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h3>{{$project->name}}</h3>
                </div>
                @if(Session::has('success_message'))
                    <script>
                        swal('success',"{!! Session::pull('success_message') !!}");
                    </script>
                @endif
                @if(Session::has('warning_message'))
                    <script>
                        swal('warning',"({!! Session::pull('warning_message') !!})");
                    </script>
                @endif
                <div class="col-md-7">
                    @if($project->projectVideo)
                        @if($project->projectVideo->self_video == 0)
                            <iframe width="100%" height="450"
                                    src="{{'https://www.youtube.com/embed/'.$project->projectVideo->link_video}}"
                                    frameborder="0" allowfullscreen></iframe>
                        @else
                            <video width="100%" height="450" controls="controls"
                                   poster="{{asset($project->poster_link)}}">
                                <source src="{{asset('/videos/'.$project->projectVideo->link_video)}}" type='video/mp4'>
                            </video>
                        @endif
                    @else
                        <img src="{{asset($project->poster_link)}}" width="650" height="450"/>
                    @endif
                </div>
                <div class="col-md-5">
                     <div class="col-xs-6 col-sm-6 col-md-6 project_main_info">
                        <span>{{ $project->getActualSumm() }}</span>
                        <p>{{trans('show_project_front.restsumm')}} {{$project->need_sum}} грн</p>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 project_main_info">
                        <h2>{{ $project->getSposoredCount() }}</h2>
                        <p>{{trans('show_project_front.sponsorcount')}}</p>
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
                        <h3 class="downCountTimer">
                            @if (\Carbon\Carbon::now()>=$project->date_finish)
                                проект завершен
                            @else
                                <span class="hidden">{{ $project->date_finish }}</span>
                                <span class="days"></span><span class="ellipsis">:</span><span class="hours"></span><span class="ellipsis">:</span><span class="minutes"></span><span class="ellipsis">:</span><span class="seconds"></span>
                            @endif
                        </h3>
                        <p>{{trans('show_project_front.projectstart')}}</p>
                        <a href="#vote" class="btn">{{trans('show_project_front.podderjat')}}</a>
                        <div class="autor">
                            @if($project->author->account->avatar_link)
                                <img src="{{asset($project->author->account->avatar_link)}}" width="50" height="50"/>
                            @else
                                <img src="{{asset('images/avatar/no-avatar.png')}}" width="50" height="50"/>
                            @endif

                            <h4>{{$project->author->name.' '.$project->author->last_name}}</h4>
                            <p>{{trans('show_project_front.projectauthor')}}</p>
                        </div>
                        <div class="sharing">
                            <button class="share">{{trans('show_project_front.share')}}</button>
                            <div class="share_popup">
                                <div class="share42init"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 project_main_info">
                        <div class="place">
                            <p>
                                <img src="{{asset('images/front/place.png')}}" width="15" height="15"/>
                                {{ ($project->city && $project->city->cld)?$project->city->cld->name:'' }}
                            </p>
                        </div>
                        <div class="media">
                            <p>
                                <img src="{{asset('images/front/media.png')}}" width="15" height="15"/>
                                {{ ($project->projectCity && $project->category->cld)?$project->category->cld->name:'' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="bg_white">
        <div class="wide-border">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#aboutproject" aria-controls="aboutproject" role="tab" data-toggle="tab" class="profile_tabs_text">{{trans('show_project_front.aboutproject')}}</a>
                                <a href="#aboutproject" aria-controls="aboutproject" role="tab" data-toggle="tab" class="profile_tabs_img"><img src="{{asset('images/front/showproject_tabs_img_1.png')}}" alt=""></a>
                            </li>
                            <li role="presentation" class="presents">
                                <a href="#presents" aria-controls="home" role="tab" data-toggle="tab" class="profile_tabs_text">{{trans('show_project_front.presents')}}</a>
                                <a href="#presents" aria-controls="home" role="tab" data-toggle="tab" class="profile_tabs_img"><img src="{{asset('images/front/showproject_tabs_img_2.png')}}" alt=""></a>
                            </li>
                            <li role="presentation" class="presents">
                                <a href="#updated" aria-controls="updated" role="tab" data-toggle="tab">{{trans('show_project_front.renew')}}</a>
                            </li>
                            
                            <li role="presentation">
                                <a href="#x_comments" aria-controls="updated" role="tab" data-toggle="tab">Комментарии</a>
                            </li>
                            
                            <li role="presentation">
                                <a href="#sponsors" aria-controls="sponsors" role="tab" data-toggle="tab" class="profile_tabs_text">{{trans('show_project_front.sponsors')}}</a>
                                <a href="#sponsors" aria-controls="sponsors" role="tab" data-toggle="tab" class="profile_tabs_img"><img src="{{asset('images/front/showproject_tabs_img_3.png')}}" alt=""></a>
                            </li>
                            {{--<li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">{{trans('show_project_front.comments')}}</a></li>--}}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="container" id="vote">
            <div class="row">
                <div class="col-xs-6 col-md-8 rewards_about">
                    <aside>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="aboutproject">
                                {!! $project->description !!}
                            </div>
                            
                            <div role="tabpanel" class="tab-pane" id="updated">
                                @include('front.project.show_tab_updated',['project'=>$project])
                            </div>
                            
                            <div role="tabpanel" class="tab-pane" id="x_comments">
                                @include('front.project.show_tab_comments',['project'=>$project])
                            </div>
                            
                            <div role="tabpanel" class="tab-pane" id="sponsors">
                                @include('front.project.show_tab_sponsored',['project'=>$project])
                            </div>
                        </div>
                    </aside>
                </div>

                <div class="col-md-4 rewards">
                    <div class="row">
                        <div class="col-md-6">
                            <h2><span class="greeny">{{trans('show_project_front.presents')}}</span></h2>
                        </div>
                    </div>
                    <article>
                        {{-- тут выводятся нагрыд проекта --}}
                        @include('front.project.gift_view', ['project'=>$project,'present' => false])       

                        @foreach($project->projectGifts as $gift)
                            @if($gift->limit != 0)
                                
                                @include('front.project.gift_view', ['project'=>$project,'present' => $gift])  
                                
                            @endif
                        @endforeach
                        
                    </article>
                </div>
            </div>
        </div>
    </section>

    <script type="text/javascript" src="{{asset('js/share42.js')}}"></script>
    <script>
        $(".share").on('click', function () {
            $(".share_popup").toggleClass("visible");
        });
    </script>
@endsection

@section('script')
<script type="text/javascript" src="{{asset('js/jquery.downCount.js')}}"></script>
<script>
    jQuery('document').ready(function($){
        $('.downCountTimer').each(function(){
            var deadline = $.trim($(this).find('.hidden').html());
            if (deadline == '') return;
            
            $(this).downCount({date: deadline,});      
            
            //console.log(deadline);         
            //console.log(this);
           
        });
        
        $(document).on('submit','._support_project_', function(e){
            e.preventDefault();
            var tforma = $(this);
            $.ajax({
              type: "POST",
              url: "{{ route('check_my_balance') }}",
              data: $(tforma).serialize(),
              success: function(msg){
                if (msg.errors !== undefined ) { 
                    swal(msg.errors, "error");
                }
                if (msg.success !== undefined) {
                    if (msg.success) {
                        tforma.removeClass('_support_project_');
                        tforma.submit();
                    } else {
                        swal('На балансе не хватает средств', "error");
                    }

                }
              }
            });
        });


    });


</script>

@endsection