@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 balanceform">
                <div class="panel text-center">
                    <h1>{{trans('user_profile.formabalance')}}</h1>
                    <p>{{trans('user_profile.addmoneyfor')}} {{Auth::user()->name}}</p>
                    <form class="inline-block" id="payment" name="payment" method="post" action="https://sci.interkassa.com/"
                          enctype="utf-8">
                        <input type="hidden" name="ik_co_id" value="599802da3d1eaf711a8b4569"/>
                        <input type="hidden"  name="ik_pm_no" value="{{Auth::user()->id}}"/>
                        <div class="form-group">
                            <label>{{trans('user_profile.insertsumm')}}</label> <!-- <i class="fa fa-eur" aria-hidden="true"></i> -->
                            <input type="number" value="" name="ik_am" minlength="0" class="form-control"  required>
                        </div>
                        <input type="hidden" name="ik_cur" value="UAH"/>
                        <input type="hidden" name="ik_desc"
                               value="{{trans('user_profile.addmoneyfor')}} - {{Auth::user()->name.' '.Auth::user()->email}}"/>
                        <button type="submit" class="btn btn-success">{{trans('user_profile.paybtn')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection