<div class="col-md-12">
    <div class="settings_block">
        <form action="{{ route('myprofile.update',Auth::id()) }}" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-8">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <input type="hidden" name="action" class="js_tab_hash" value="#myabout">

                    <div class="firstname">
                        <label for="name">{{trans('user_profile.name')}}</label>
                        <input type="text" name="name" value="{{Auth::user()->name}}" class="form-control">
                        @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="lastname">
                        <label for="last_name">{{trans('user_profile.surename')}}</label>
                        <input type="text" name="last_name" value="{{Auth::user()->last_name}}"
                        class="form-control ">
                        @if ($errors->has('last_name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('last_name') }}</strong>
                        </span>
                        @endif
                    </div>
                    <label for="avatar">{{trans('user_profile.ava')}}</label>
                    <div class="media_profile">
                        <a href="#">
                            <img src="{{ asset(Auth::user()->avatar) }}" height="88" width="94" alt="">
                        </a>
                        <div class="media_profile_info">
                            <input type="file" name="avatar" accept="image/jpeg,image/png">
                            @if ($errors->has('avatar'))
                            <span class="help-block">
                                <strong>{{ $errors->first('avatar') }}</strong>
                            </span>
                            @endif
                            {!!trans('user_profile.avaparam')!!}
                        </div>
                    </div>
                    <div class="city">
                        <label for="city">{{trans('user_profile.town')}}</label>
                        <input type="text" name="city" value="{{Auth::user()->account->city_birth}}"
                        class="form-control">
                        @if ($errors->has('city'))
                        <span class="help-block">
                            <strong>{{ $errors->first('city') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="phone">
                        <label for="contact_phone">{{trans('user_profile.phone')}}</label>
                        <span>+380</span><input type="text" name="contact_phone" value="{{Auth::user()->account->contact_phone}}"
                        class="form-control">
                        @if ($errors->has('contact_phone'))
                        <span class="help-block">
                            <strong>{{ $errors->first('contact_phone') }}</strong>
                        </span>
                        @endif
                    </div>
                    
                    <!-- </form> -->
                </div>
                <div class="col-md-4 text-center">
                    <label for="about_self">{{trans('user_profile.aboutself')}}</label>
                    @if ($errors->has('about_self'))
                    <span class="help-block">
                        <strong>{{ $errors->first('about_self') }}</strong>
                    </span>
                    @endif
                    <textarea name="about_self" rows="8">{{Auth::user()->account->about_self}}</textarea>
                </div>
                <div class="settings_btn">
                        <button type="submit">{{trans('user_profile.save')}}</button>
                    </div>
            </div>
        </form>
    </div>
</div>


