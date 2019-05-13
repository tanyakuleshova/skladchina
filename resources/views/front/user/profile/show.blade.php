@extends('layouts.app')

@section('title', 'Профиль')

@section('content')
<section class="profile_main">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h2 class="caption">{{ Auth::user()->fullName }}</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-8 col-sm-8 col-md-9 profile_main_photo">
                <div class="profile_main_img">
                    <img src="{{ asset( Auth::user()->avatar) }}" alt="avatar">
                </div>
                <div class="description">{{Auth::user()->account->about_self}}</div>
                <div class="place">
                    <p>
                        <img src="{{asset('images/front/place.png')}}" width="15" height="15" />
                        {{Auth::user()->account->city_birth}}
                    </p>
                </div>
                <!-- <p>{{Auth::user()->account->city_birth}}</p> -->
            </div>
            <div class="col-xs-4 col-sm-4 col-md-3 profile_main_info">
                <p>Баланс: <span>{{ Auth::user()->getMyBalance() }} грн.</span></p>
                <a href="{{ route('mybalance.index') }}">
                    <button>{{trans('user_profile.addmoneybtn')}}</button>
                </a>
                <a href="{{ route('myprojects.index') }}" class="user-page-myproject">
                    <button>{{trans('user_profile.myprojects')}}</button>
                </a>
            </div>
        </div>
    </div>
</section>

<section class="profile_tabs">
    
    <div class="wide-border">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist" id="navigation_my_profile">
                        @if(Auth::user()->getSponsoredProjects()->count())
                        <li role="presentation">
                            <a href="#sponsored" aria-controls="sponsored" role="tab" data-toggle="tab" class="profile_tabs_text">{{trans('user_profile.supportproject')}}</a>
                            <a href="#sponsored" aria-controls="sponsored" role="tab" data-toggle="tab" class="profile_tabs_img"><img src="{{asset('images/front/profile_tabs_img_1.png')}}" alt=""></a>
                        </li>
                        @endif
                        
                        @if(Auth::user()->gifts()->count())
                        <li role="presentation">
                            <a href="#mygifts" aria-controls="mygifts" role="tab" data-toggle="tab" class="profile_tabs_text">{{trans('user_profile.mypresents')}}</a>
                            <a href="#mygifts" aria-controls="mygifts" role="tab" data-toggle="tab" class="profile_tabs_img"><img src="{{asset('images/front/profile_tabs_img_3.png')}}" alt=""></a>
                        </li>
                        @endif
                        
                        <li role="presentation">
                            <a href="#myabout" aria-controls="myabout" role="tab" data-toggle="tab" class="profile_tabs_text">{{trans('user_profile.about')}}</a>
                            <a href="#myabout" aria-controls="myabout" role="tab" data-toggle="tab" class="profile_tabs_img"><img src="{{asset('images/front/profile_settings_img_1.png')}}" alt=""></a>
                        </li>

                        <li role="presentation">
                            <a href="#mysocials" aria-controls="mysocials" role="tab" data-toggle="tab" class="profile_tabs_text">{{trans('user_profile.contacts')}}</a>
                            <a href="#mysocials" aria-controls="mysocials" role="tab" data-toggle="tab" class="profile_tabs_img"><img src="{{asset('images/front/profile_settings_img_2.png')}}" alt=""></a>
                        </li>
                        
                        <li role="presentation">
                            <a href="#mysecurity" aria-controls="mysecurity" role="tab" data-toggle="tab" class="profile_tabs_text">{{trans('user_profile.security')}}</a>
                            <a href="#mysecurity" aria-controls="mysecurity" role="tab" data-toggle="tab" class="profile_tabs_img"><img src="{{asset('images/front/profile_settings_img_3.png')}}" alt=""></a>
                        </li>
                        
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <!-- Tab panes -->
            <div class="tab-content">
                @if(Auth::user()->getSponsoredProjects()->count())
                <div role="tabpanel" class="tab-pane fade" id="sponsored">
                    @include('front.user.profile.tab_sponsored')
                </div>
                @endif
                
                @if(Auth::user()->gifts()->count())
                <div role="tabpanel" class="tab-pane fade" id="mygifts">
                    @include('front.user.profile.tab_myfigts')
                </div>
                @endif
                
                <div role="tabpanel" class="tab-pane fade" id="myabout">
                    @include('front.user.profile.tab_myabout')
                </div>
                
                <div role="tabpanel" class="tab-pane fade" id="mysocials">
                    @include('front.user.profile.tab_mysocials')
                </div>
                
                <div role="tabpanel" class="tab-pane fade" id="mysecurity">
                    @include('front.user.profile.tab_mysecurity')
                </div>
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
    var navbars =  $('#navigation_my_profile li[role="presentation"] a');
    navbars.on('click',function(){ UrlHashReadRewrite(this.hash); });
    InitLoadAndClick();
    function UrlHashReadRewrite(newhash) {
            if (newhash === undefined) { return window.location.hash?window.location.hash:"{{ old('action') }}"; }/////////////////////////////
            window.location.hash = newhash;
        }
        function InitLoadAndClick(){
            var curent_hash = UrlHashReadRewrite();
            if (curent_hash !== '' && navbars.is('[href="' + curent_hash + '"]')) {
                navbars.filter('[href="' + curent_hash + '"]').first().click()
            } else {
                $('#navigation_my_profile a:first').click();
            }
        }
        if ("onhashchange" in window) { window.onhashchange = InitLoadAndClick;}
        /* конец блока навигации по табам на основе хешей */
    });
</script>
@endsection

