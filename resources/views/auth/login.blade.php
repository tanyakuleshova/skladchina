@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row registration_wrap">
            <div class="col-md-8 col-md-offset-2">
                <h2 class="text-center"><span class="greeny">{{trans('nav_front.login')}}</span></h2>
                <div class="registration_inner">
                    <form method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <input id="email" type="email" class="form-control" placeholder="Email" name="email"
                                   value="{{ old('email') }}" required autofocus>
                            @if ($errors->has('email'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <input id="password" placeholder="{{trans('auth.password')}}" type="password" class="form-control"
                                   name="password" required>
                            @if ($errors->has('password'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <button type="submit" class="btn entry_btn">
                            {{trans('nav_front.login')}}
                        </button>
                    </form>
                    <a class="forget_pass" href="{{ route('password.request') }}">{{trans('auth.forgot_password')}}</a>
                    <hr>
                    <div class="registration">
                        <a href="{{ route('register') }}">{{trans('nav_front.register_user')}}</a>
                    </div>
                    <div class="entry_social_btn">
                        <a class="btn entry_fb" href="{{url('auth/facebook')}}">Facebook</a>
                        <a class="btn entry_gplus" href="{{url('auth/google')}}">Google+</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
