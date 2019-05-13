@extends('layouts.app')
@section('content')
    <div class="wrap">
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="money_wrap">
                            <h2 class="caption">{{trans('user_profile.askmoneyfor')}}</h2>
                        </div>
                    </div>
                </div>
                @if(Session::has('success_message'))
                    <div class="container">
                        <div class="alert alert-success">{{Session::get('success_message')}}</div>
                    </div>
                @endif
                @if(Session::has('warning_message'))
                    <div class="container">
                        <div class="alert alert-warning">{{Session::get('warning_message')}}</div>
                    </div>
                @endif
                <div class="row">
                    <div class="col-md-12">
                        <div class="money_rules">
                            <h2>{{trans('user_profile.rules')}}</h2>
                            {!!trans('user_profile.textrules')!!}
                            {{--<button>завантажити заяву</button>--}}
                            <h3>{{trans('user_profile.zajava')}}</h3>
                            <form action="{{route('withdraw_money')}}" method="post"  enctype="multipart/form-data">
                                {{csrf_field()}}
                                <div class="media_profile">
                                    <a href="#">
                                        <img src="{{asset('images/front/add_photo.png')}}" height="88" width="94" alt="">
                                    </a>
                                    <div class="media_profile_info">
                                        @if ($errors->has('application_image'))
                                        <span class="help-block">
                                          <strong>{{ $errors->first('application_image') }}</strong>
                                        </span>
                                        @endif
                                        <input type="file" name="application_image" multiple accept="image/jpeg,image/png" required>
                                        {{--<span>Завантажити зображення</span>--}}
                                        {!!trans('user_profile.imgdoc')!!}
                                    </div>
                                </div>
                                <label>{{trans('user_profile.summ')}}</label>
                                @if ($errors->has('money_sum'))
                                    <span class="help-block">
                                          <strong>{{ $errors->first('money_sum') }}</strong>
                                        </span>
                                @endif
                                <input type="number" name="money_sum" placeholder="грн." required>
                                <label>{{trans('user_profile.datacard')}}</label>
                                @if ($errors->has('type_cart'))
                                    <span class="help-block">
                                          <strong>{{ $errors->first('type_cart') }}</strong>
                                        </span>
                                @endif
                                <select name="type_cart">
                                    <option disabled selected>{{trans('user_profile.typecard')}}</option>
                                    <option value="Кредитная/дебетовая карта">{{trans('user_profile.creditcard')}}</option>
                                    <option value="Кошелек webmoney">{{trans('user_profile.webmoney')}}</option>
                                </select>
                                @if ($errors->has('number'))
                                    <span class="help-block">
                                          <strong>{{ $errors->first('number') }}</strong>
                                        </span>
                                @endif
                                <input type="text" name="number" placeholder="0/16" required>
                                <button type="submit">{{trans('user_profile.outsidemoney')}}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection