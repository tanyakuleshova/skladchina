@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row registration_wrap">
        <div class="col-md-8 col-md-offset-2">
                <h2 class="text-center"><span class="greeny">{{trans('nav_front.register_user')}}</span></h2>
                <div class="registration_inner">
                    <form class="form_wrap" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <input id="name" placeholder="{{trans('auth.name')}}" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                        </div>
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <input id="email" placeholder="Email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <input id="password" placeholder="{{trans('auth.password')}}"  type="password" class="form-control" name="password" required>
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                        </div>
                                <input id="password-confirm" placeholder="{{trans('auth.password_confirmation')}}"  type="password" class="form-control" name="password_confirmation" required>
                                <button type="submit" class="btn entry_btn">
                                    {{trans('auth.reg_user')}}
                                </button>
                        <p>{{trans('auth.req_rules_1')}}<a href=""> {{trans('auth.reg_rule')}}</a> {{trans('auth.i')}} <a href="">{{trans('auth.reg_politics')}}</a> {{trans('auth.reg_rules_2')}}</p>
                    </form>
            </div>
        </div>
    </div>
</div>
@endsection
