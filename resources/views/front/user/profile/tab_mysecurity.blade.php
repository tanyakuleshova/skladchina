<div class="col-md-12">
    <div class="settings_block settings_security">
        <div class="row">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="top_reset">{{trans('user_profile.passchange')}}</h3>
                        
                        <form action="{{ route('myprofile.update',Auth::id()) }}" method="post">
                            {{csrf_field()}}
                            {{ method_field('PUT') }}
                            <input type="hidden" name="action" class="js_tab_hash" value="#mysecurity">
                            <input type="hidden" name="subaction" class="js_tab_hash" value="password">
                            
                            <label>{{trans('user_profile.oldpass')}}</label>
                            <input type="password" name="old_password" required>
                            @if ($errors->has('old_password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('old_password') }}</strong>
                            </span>
                            @endif
                            <label>{{trans('user_profile.newpass')}}</label>
                            <input type="password" name="new_password" required>
                            @if ($errors->has('new_password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('new_password') }}</strong>
                            </span>
                            @endif
                            <label>{{trans('user_profile.newpassreap')}}</label>
                            <input type="password" name="password_confirm" required>
                            @if ($errors->has('password_confirm'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password_confirm') }}</strong>
                            </span>
                            @endif
                            <div class="settings_btn security_btn">
                                <button type="submit">{{trans('user_profile.save')}}</button>
                            </div>
                        </form>
                        
                    </div>
                    <div class="col-md-6">
                        <h3 class="top_reset change-mail">{{trans('user_profile.emailchange')}}</h3>
                        
                        <form action="{{ route('myprofile.update',Auth::id()) }}" method="post">
                            {{csrf_field()}}
                            {{ method_field('PUT') }}
                            <input type="hidden" name="action" class="js_tab_hash" value="#mysecurity">
                            <input type="hidden" name="subaction" class="js_tab_hash" value="email">
                            
                            <label>{{trans('user_profile.emailchangepass')}}</label>
                            <input type="password" name="password" required>
                            <label>{{trans('user_profile.emailchangeold')}}</label>
                            <input type="email" name="old_email" required>
                            <label>{{trans('user_profile.emailchangenew')}}</label>
                            <input type="email" name="new_email" required>
                            <div class="settings_btn security_btn">
                                <button type="submit">{{trans('user_profile.save')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                {!! trans('user_profile.security_rules') !!}
            </div>
        </div>
    </div>
</div>