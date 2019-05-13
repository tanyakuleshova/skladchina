<div class="col-md-12">
    <div class="settings_block settings_contacts">
        <div class="row">
            <div class="col-md-8">
                <form action="{{ route('myprofile.update',Auth::id()) }}" method="post">
                    {{ csrf_field() }}        
                    {{ method_field('PUT') }}
                    <input type="hidden" name="action" class="js_tab_hash" value="#mysocials">
                    
                    <h3 class="top_reset">{{trans('user_profile.website')}}</h3>
                    <div class="social_wrap">
                        <div class="settings_social">
                            <button class="settings_btn_site" disabled><i class="fa fa-map-marker" aria-hidden="true"></i></button>
                        </div>
                        <input type="text" name="site" value="{{Auth::user()->account->user_site}}">
                    </div>
                    
                    <h3>{{trans('user_profile.social')}}</h3>
                    <div class="social_wrap">
                        <div class="settings_social settings_fb"></div>
                        <input type="text" value="{{Auth::user()->account->social_href_facebook}}"
                        name="sc_facebook">
                    </div>
                    <div class="social_wrap">
                        <div class="settings_social settings_goo"></div>
                        <input type="text" value="{{Auth::user()->account->social_href_google}}"
                        name="sc_google">
                    </div>
                    <div class="social_wrap">
                        <div class="settings_social settings_tw"></div>
                        <input type="text" value="{{Auth::user()->account->social_href_twitter}}"
                        name="sc_twitter">
                    </div>
                    <div class="social_wrap">
                        <div class="settings_social settings_yb"></div>
                        <input type="text" value="{{Auth::user()->account->social_href_youtube}}"
                        name="sc_youtube">
                    </div>
                    <div class="social_wrap">
                        <div class="settings_social settings_inst"></div>
                        <input type="text" value="{{Auth::user()->account->social_href_instagram}}"
                        name="sc_instagram">
                    </div>
                    <div class="settings_btn socials_btn">
                        <button type="submit">{{trans('user_profile.save')}}</button>
                    </div>
                </form>
            </div>
            <div class="col-md-4">
                {!! trans('user_profile.social_rules') !!}
            </div>
        </div>
    </div>
</div>