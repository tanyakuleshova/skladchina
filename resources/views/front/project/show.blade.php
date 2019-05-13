{{-- приведение к нормальным именам --}}
@extends('layouts.app')
@section('meta-description',$project->name.', '.$project->short_desc)
@section('title',$project->name)
@section('meta-keywords')
    <meta property="og:image" content="{{ asset($project->poster) }}" />
@endsection
@section('content')



    @include('front.project._partials.project_head',['project' => $project])

    <section class="bg_white">
        <div class="wide-border">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 mobile-tabs">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" id="omg" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#aboutproject" aria-controls="aboutproject" role="tab" data-toggle="tab" class="profile_tabs_text"> {{trans('show_project_front.aboutproject')}}</a>
                                <!--a href="#aboutproject" aria-controls="aboutproject" role="tab" data-toggle="tab" class="profile_tabs_img"></a-->
                            </li>
                            <li role="presentation" class="presents">
                                <a href="#presents" aria-controls="home" role="tab" data-toggle="tab" class="profile_tabs_text"> {{trans('show_project_front.presents')}}</a>
                                <!--a href="#presents" aria-controls="home" role="tab" data-toggle="tab" class="profile_tabs_img"></a-->
                            </li>
                            @if($project->pupdates()->approved()->count())
                            <li role="presentation">
                                <a href="#updated" aria-controls="updated" role="tab" data-toggle="tab" class="profile_tabs_text"> {{trans('show_project_front.renew')}} <span class="badge badge-info">{{$project->pupdates()->approved()->count()}}</span></a>
                                <!--a href="#updated" aria-controls="updated" role="tab" data-toggle="tab" class="profile_tabs_img"></a-->
                            </li>
                            @endif
                            <li role="presentation">
                                <a href="#x_comments" aria-controls="updated" role="tab" data-toggle="tab" class="profile_tabs_text"> Комментарии <span class="badge badge-info">{{$project->comments()->count()?:''}}</span></a>
                                <!--a href="#x_comments" aria-controls="updated" role="tab" data-toggle="tab" class="profile_tabs_img"></a-->
                            </li>
                            @if($project->getSposoredCount())
                            <li role="presentation">
                                <a href="#users" aria-controls="users" role="tab" data-toggle="tab" class="profile_tabs_text"> {{trans('show_project_front.sponsors')}} <span class="badge badge-info">{{$project->getSposoredCount()}}</span></a>
                                <!--a href="#users" aria-controls="users" role="tab" data-toggle="tab" class="profile_tabs_img"></a-->
                            </li>
                            @endif
                            
                            @if($project->isClosedFail && $project->getFailOrderSponsoredCount())
                            <li role="presentation">
                                <a href="#usersfail" aria-controls="usersfail" role="tab" data-toggle="tab" class="profile_tabs_text"> {{trans('show_project_front.failsponsorcount')}} <span class="badge badge-info">{{ $project->getFailOrderSponsoredCount() }}</span></a>
                                <!--a href="#users" aria-controls="users" role="tab" data-toggle="tab" class="profile_tabs_img"></a-->
                            </li>
                            @endif
                            
                            
                            {{--<li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">{{trans('show_project_front.comments')}}</a></li>--}}
                        </ul>
                        <script>
                            $(document).ready(function()
                            {   
                                var full_weight=0;
                                $("#omg li").each(function(){
                                full_weight+=$(this).width();
                                });
                                //alert(full_weight);
                                $("#omg").css('width', full_weight);
                            });
                            
                        </script>
                    </div>
                </div>
            </div>
        </div>
        <div class="container" id="vote">
            <div class="row">

                <!----------------------------------------------col-md-8 изменено на col-md-4 -->
                <div class="col-xs-12 col-md-8 rewards_about">
                    <aside>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="aboutproject">
                                {!! $project->description !!}
                            </div>

                            <div role="tabpanel" class="tab-pane" id="presents">
                                <div class="rewards">
                                    @include('front.project.gift_view', ['project'=>$project,'present' => false])
                                    @foreach($project->projectGifts as $gift)
                                    @include('front.project.gift_view', ['project'=>$project,'present' => $gift])
                                    @endforeach
                                </div>
                            </div>
                            
                            <div role="tabpanel" class="tab-pane" id="updated">
                                @include('front.project.show_tabs.updated',['project'=>$project])
                            </div>
                            
                            <div role="tabpanel" class="tab-pane" id="x_comments">
                                @include('front.project.show_tabs.comments',['project'=>$project])
                            </div>
                            @if($project->getSposoredCount())
                            <div role="tabpanel" class="tab-pane" id="users">
                                @include('front.project.show_tabs.sponsors',['project'=>$project])
                            </div>
                            @endif
                            @if($project->isClosedFail && $project->getFailOrderSponsoredCount())
                            <div role="tabpanel" class="tab-pane" id="usersfail">
                                @include('front.project.show_tabs.sponsors',['project'=>$project])
                            </div>
                            @endif
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
                                @include('front.project.gift_view', ['project'=>$project,'present' => $gift])  
                        @endforeach
                        
                    </article>
                </div>
        </div>

        </div>
    </section>

    <script type="text/javascript" src="{{asset('js/share42.js')}}"></script>
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
        
//        $(document).on('submit','._support_project_', function(e){
//            e.preventDefault();
//            var tforma = $(this);
//            $.ajax({
//              type: "POST",
//              url: "{{ route('check_my_balance') }}",
//              data: $(tforma).serialize(),
//              success: function(msg){
//                if (msg.errors !== undefined ) { 
//                    swal(msg.errors, "error");
//                }
//                if (msg.success !== undefined) {
//                    if (msg.success) {
//                        tforma.removeClass('_support_project_');
//                        tforma.submit();
//                    } else {
//                        
//                        swal({
//                          title: "Не хватает средств",
//                          text: "Вы можете пополнить баланс и поддержать проект.",
//                          type: "warning",
//                          showCancelButton: true,
//                          confirmButtonClass: "btn-danger",
//                          confirmButtonText: "Пополнить",
//                          cancelButtonText: "Отказаться",
//                          closeOnConfirm: false,
//                          closeOnCancel: true
//                        },
//                        function(isConfirm) {
//                          if (isConfirm) {
//                            window.location.href = '{{ route('mybalance.index')}}';
//                          } 
//                        });
//                    }
//                }
//              },
//            error:function(msg){
//                console.log(msg);
//            }
//            });
//        });


    });


</script>

@endsection