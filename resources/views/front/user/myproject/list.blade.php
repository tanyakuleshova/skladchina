@extends('layouts.app')
@section('title','Мои проекты')
@section('content')
<section class="list_products">

    <h1 class="text-center">{{trans('user_profile.my_project')}}</h1>


    <div class="wide-border">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist" id="navigation_my_projects">
                        @if(count($active_pro))
                        <li role="presentation">
                            <a href="#active_pro" aria-controls="active_pro" role="tab" data-toggle="tab" class="profile_tabs_text">Активные</a>
                            <a href="#active_pro" aria-controls="active_pro" role="tab" data-toggle="tab" class="profile_tabs_img" title="Активные"><i class="fa fa-refresh fa-spin fa-2x fa-fw"></i></a>
                        </li>
                        @endif
                        @if(count($moderation_pro))
                        <li role="presentation">
                            <a href="#moderation_pro" aria-controls="moderation_pro" role="tab" data-toggle="tab" class="profile_tabs_text">На модерации</a>
                            <a href="#moderation_pro" aria-controls="moderation_pro" role="tab" data-toggle="tab" class="profile_tabs_img"title="На модерации"><i class="fa fa-users fa-2x" aria-hidden="true"></i></a>
                        </li>
                        @endif
                        @if(count($new_my_pro))
                        <li role="presentation">
                            <a href="#new_my_pro" aria-controls="new_my_pro" role="tab" data-toggle="tab" class="profile_tabs_text">Редактирование</a>
                            <a href="#new_my_pro" aria-controls="new_my_pro" role="tab" data-toggle="tab" class="profile_tabs_img" title="Редактирование"><i class="fa fa-newspaper-o fa-2x" aria-hidden="true"></i></a>
                        </li>
                        @endif
                        @if(count($closed_pro))
                        <li role="presentation">
                            <a href="#closed_pro" aria-controls="closed_pro" role="tab" data-toggle="tab" class="profile_tabs_text">Завершённые</a>
                            <a href="#closed_pro" aria-controls="closed_pro" role="tab" data-toggle="tab" class="profile_tabs_img" title="Завершённые"><i class="fa fa-check-circle-o fa-2x" aria-hidden="true"></i></a>
                        </li>
                        @endif
                    </ul>
                    <!-- / Nav tabs -->
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <!-- Tab panes -->
            <div class="tab-content">
                @if(count($active_pro))
                <div role="tabpanel" class="tab-pane fade" id="active_pro">
                    @include('front.user.myproject.tabs.active',['projects'=>$active_pro])
                </div>
                @endif
                @if(count($moderation_pro))
                    <div role="tabpanel" class="tab-pane fade" id="moderation_pro">
                        @include('front.user.myproject.tabs.moderation',['projects'=>$moderation_pro])
                    </div>
                @endif
                @if(count($new_my_pro))
                    <div role="tabpanel" class="tab-pane fade" id="new_my_pro">
                        @include('front.user.myproject.tabs.edited',['projects'=>$new_my_pro])
                    </div>
                @endif
                @if(count($closed_pro))
                    <div role="tabpanel" class="tab-pane fade" id="closed_pro">
                        @include('front.user.myproject.tabs.closed',['projects'=>$closed_pro])
                    </div>
                @endif
            </div>
        </div>
    </div>


</section>
@endsection

@section('script')
<script type="text/javascript" src="{{asset('js/jquery.downCount.js')}}"></script>
<script>
jQuery('document').ready(function($){
	$('.downCountTimer').each(function(){
		var deadline = $.trim($(this).find('.hidden').html());
		if (deadline == '') return;
		$(this).downCount({date: deadline,});      
	});
        
        
        /* блок навигации по табам на основе хешей */
        var navbars =  $('#navigation_my_projects li[role="presentation"] a');
        navbars.on('click',function(){ UrlHashReadRewrite(this.hash); });
        InitLoadAndClick();
        function UrlHashReadRewrite(newhash) {
            if (newhash === undefined) { return window.location.hash?window.location.hash:"{{ old('action') }}"; }/////////////////////////////
            window.location.hash = newhash;
        }
        function InitLoadAndClick(){
            var curent_hash = UrlHashReadRewrite();
            console.log('"' + curent_hash + '"');
            if (curent_hash !== '' && navbars.is('[href="' + curent_hash + '"]')) {
                navbars.filter('[href="' + curent_hash + '"]').first().click()
            } else {
                $('#navigation_my_projects a:first').click();
            }
        }
        if ("onhashchange" in window) { window.onhashchange = InitLoadAndClick;}
        /* конец блока навигации по табам на основе хешей */
});
</script>
@endsection
