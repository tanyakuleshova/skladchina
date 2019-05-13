@extends('layouts.app')
@section('content')
<section class="settings">
		<div class="container">
				<div class="row">
						<div class="col-md-12">
								<h2 class="caption">налаштування</h2>
						</div>
				</div>
		</div>
</section>
@if(Session::has('success_message'))
<div class="container">
		<span class="alert-success">{{Session::get('success_message')}}</span>
</div>
@endif
@if(Session::has('warning_message'))
<div class="container">
		<span class="alert-warning">{{Session::get('warning_message')}}</span>
</div>
@endif
<section class="settings_wrap">
		<div class="wide-border">
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-md-12">
						<!-- Nav tabs -->
						<ul class="nav nav-tabs" role="tablist">
							<li role="presentation" class="active">
								<a href="#tab1" aria-controls="about" role="tab" data-toggle="tab" class="profile_tabs_text">{{trans('user_profile.about')}}</a>
								<a href="#tab1" aria-controls="about" role="tab" data-toggle="tab" class="profile_tabs_img"><img src="{{asset('images/front/profile_settings_img_1.png')}}" alt=""></a>
							</li>
							<li role="presentation">
								<a href="#tab2" aria-controls="socials" role="tab" data-toggle="tab" class="profile_tabs_text">{{trans('user_profile.contacts')}}</a>
								<a href="#tab2" aria-controls="socials" role="tab" data-toggle="tab" class="profile_tabs_img"><img src="{{asset('images/front/profile_settings_img_2.png')}}" alt=""></a>
							</li>
							<li role="presentation">
								<a href="#tab3" aria-controls="security" role="tab" data-toggle="tab" class="profile_tabs_text">{{trans('user_profile.security')}}</a>
								<a href="#tab3" aria-controls="security" role="tab" data-toggle="tab" class="profile_tabs_img"><img src="{{asset('images/front/profile_settings_img_3.png')}}" alt=""></a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row">
				<!-- Tab panes -->
				<div class="col-md-12">
					<div class="tab-content">
						<div role="tabpanel" class="tab-pane active" id="tab1">
							<div class="col-md-12 settings_block">
								<form action="{{route('update_setting_profile')}}" method="POST"
								enctype="multipart/form-data">
								{{ csrf_field() }}
								<label for="name" f>{{trans('user_profile.name')}}</label>
								<input type="text" name="name" value="{{Auth::user()->name}}" class="form-control">
								@if ($errors->has('name'))
								<span class="help-block">
									<strong>{{ $errors->first('name') }}</strong>
								</span>
								@endif
								<label for="last_name">{{trans('user_profile.surename')}}</label>
								<input type="text" name="last_name" value="{{Auth::user()->last_name}}"
								class="form-control">
								@if ($errors->has('last_name'))
								<span class="help-block">
									<strong>{{ $errors->first('last_name') }}</strong>
								</span>
								@endif
								<label for="avatar">{{trans('user_profile.ava')}}</label>
								<div class="media_profile">
									<a href="#">
										<img src="{{ asset(Auth::user()->avatar) }}" height="88" width="94" alt="">
									</a>
									<div class="media_profile_info">
										<input type="file" name="avatar" multiple accept="image/jpeg,image/png">
										@if ($errors->has('avatar'))
										<span class="help-block">
											<strong>{{ $errors->first('avatar') }}</strong>
										</span>
										@endif
										{!!trans('user_profile.avaparam')!!}
									</div>
								</div>
								<label for="city">{{trans('user_profile.town')}}</label>
								<input type="text" name="city" value="{{Auth::user()->account->city_birth}}"
								class="form-control">
								@if ($errors->has('city'))
								<span class="help-block">
									<strong>{{ $errors->first('city') }}</strong>
								</span>
								@endif
								<label for="contact_phone">{{trans('user_profile.phone')}}</label>
								<input type="text" name="contact_phone" value="{{Auth::user()->account->contact_phone}}"
								class="form-control">
								@if ($errors->has('contact_phone'))
								<span class="help-block">
									<strong>{{ $errors->first('contact_phone') }}</strong>
								</span>
								@endif
								<label for="about_self">{{trans('user_profile.aboutself')}}</label>
								@if ($errors->has('about_self'))
								<span class="help-block">
									<strong>{{ $errors->first('about_self') }}</strong>
								</span>
								@endif
								<textarea name="about_self" rows="8">{{Auth::user()->account->about_self}}</textarea>
								<button type="submit">{{trans('user_profile.save')}}</button>
							</form>
						</div>
					</div>
					<div role="tabpanel" class="tab-pane" id="tab2">
						<div class="col-md-12 settings_block settings_contacts">
							<form action="{{route('add_social_info')}}" method="post">
								{{ csrf_field() }}
								<h3 class="top_reset">{{trans('user_profile.website')}}</h3>
								<p>http://google.com</p>
								<input type="text" name="site" value="{{Auth::user()->account->user_site}}"
								class="settings_input_site">
								<button class="settings_btn_site" disabled>+</button>
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
								<button type="submit">{{trans('user_profile.save')}}</button>
							</form>
						</div>
					</div>
					<div role="tabpanel" class="tab-pane" id="tab3">
						<div class="col-md-12 settings_block settings_security">
							<div class="row">

								<div class="col-md-6">
									<h3 class="top_reset">{{trans('user_profile.passchange')}}</h3>
									<form action="{{route('change_password')}}" method="post">
										{{csrf_field()}}
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
										<button type="submit">{{trans('user_profile.save')}}</button>
									</form>
								</div>
								<div class="col-md-6">
									<h3 class="top_reset">{{trans('user_profile.emailchange')}}</h3>
									<form action="{{route('change_email')}}" method="post">
										{{csrf_field()}}
										<label>{{trans('user_profile.emailchangepass')}}</label>
										<input type="password" name="password" required>
										<label>{{trans('user_profile.emailchangeold')}}</label>
										<input type="email" name="old_email" required>
										<label>{{trans('user_profile.emailchangenew')}}</label>
										<input type="email" name="new_email" required>
										<button type="submit">{{trans('user_profile.save')}}</button>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection