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
                    <div class="col-xs-12">
                        <div class="money_rules">
                            <div class="row">
                                <div class="col-md-6">
                                    <h2>{{trans('user_profile.rules')}}</h2>
                                    {!!trans('user_profile.textrules')!!}
                                </div>

                                <div class="col-md-6">
                                    <form action="{{route('refund.store')}}" method="post"  enctype="multipart/form-data">
                                        {{csrf_field()}}
                                        <h3>{{trans('user_profile.zajava')}}</h3>
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
                                              <input type="file" name="application_image" multiple accept="image/jpeg,image/png" >
                                              {!!trans('user_profile.imgdoc')!!}
                                          </div>
                                      </div>

                                      <label>{{trans('user_profile.summ')}}</label>
                                      @if ($errors->has('summa'))
                                      <span class="help-block">
                                          <strong>{{ $errors->first('summa') }}</strong>
                                      </span>
                                      @endif
                                      <input type="number" name="summa" placeholder="грн." value="{{ old('summa')}}" required>

                                      <label>{{trans('user_profile.datacard')}}</label>
                                      @if ($errors->has('paymethod'))
                                      <span class="help-block">
                                          <strong>{{ $errors->first('paymethod') }}</strong>
                                      </span>
                                      @endif
                                      <select name="paymethod" class="pr_selector">
                                        <option disabled selected>{{trans('user_profile.typecard')}}</option>
                                        @foreach ($listpm as $pm)
                                        <option value="{{ $pm->id }}" {{ old('paymethod')==$pm->id?'selected':''}}>{{ $pm->name }}</option>
                                        @endforeach
                                    </select>
                                    
                                    @if ($errors->has('number'))
                                    <span class="help-block">
                                      <strong>{{ $errors->first('number') }}</strong>
                                  </span>
                                  @endif
                                  <input type="text" name="number" placeholder="0/16" value="{{ old('number')}}" required>
                                  <div class="money_rules_btn">
                                    <button type="submit">{{trans('user_profile.outsidemoney')}}</button>
                                    <!--button type="submit" class="pull-right">Скачать заявление</button-->
                                    <a href="/documents/Zayava_vozvrat_sredstv.doc" download="Zayava_vozvrat_sredstv.doc" class="pull-right downloadzajava">Скачать заявление</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="create-balance-wrap">
                            <a href="{{ route('mybalance.index') }}" class="btn btn-info">Назад, Мои финансы</a>
                            <a href="{{route('refund.index')}}" class="btn btn-info">Назад, Мои заявки</a>
                        </div>
                    </div>
                </div>
                
            </div>
        </section>
    </div>
@endsection