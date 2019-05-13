{{-- это просто физ.лицо  --}}
<form action="{{route('fop_project_form',$project->id)}}"  method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        <label>{{trans('createproject.pib')}}<img src="{{asset('images/front/tooltip.png')}}" alt="" data-toggle="tooltip" data-placement="right" class="bg-tooltip" title='{{trans('createproject.qfio')}}'></label>
        @if ($errors->has('FIO'))
        <span class="help-block">
                <strong>{{ $errors->first('FIO') }}</strong>
        </span>
        @endif
        <input type="text" name="FIO" value="{{old('FIO')?old('FIO'):$project->requisites->FIO}}">
        <label>{{trans('createproject.bdate')}}</label>
        @if ($errors->has('date_birth'))
        <span class="help-block">
                <strong>{{ $errors->first('date_birth') }}</strong>
        </span>
        @endif
        <input type="date" name="date_birth" value="{{old('date_birth')?old('date_birth'):$project->requisites->date_birth}}">
        <label>{{trans('createproject.cityreg')}}</label>
        @if ($errors->has('country_register'))
        <span class="help-block">
                <strong>{{ $errors->first('country_register') }}</strong>
        </span>
        @endif
        <input type="text" name="country_register" value="{{old('country_register')?old('country_register'):$project->requisites->country_register}}">
        <label>{{trans('createproject.town')}}</label>
        @if ($errors->has('city'))
        <span class="help-block">
                <strong>{{ $errors->first('city') }}</strong>
        </span>
        @endif
        <input type="text" name="city" value="{{old('city')?old('city'):$project->requisites->city}}">
        <label>{{trans('createproject.phone')}}</label>
        @if ($errors->has('phone'))
        <span class="help-block">
                <strong>{{ $errors->first('phone') }}</strong>
        </span>
        @endif
        <input type="text" name="phone" value="{{old('phone')?old('phone'):$project->requisites->phone}}">
        <label>{{trans('createproject.inn')}}</label>
        @if ($errors->has('inn_or_rdpo'))
        <span class="help-block">
                <strong>{{ $errors->first('inn_or_rdpo') }}</strong>
        </span>
        @endif
        <input type="text" name="inn_or_rdpo" value="{{old('inn_or_rdpo')?old('inn_or_rdpo'):$project->requisites->inn_or_rdpo}}">
        <label>{{trans('createproject.passport')}}</label>
        @if ($errors->has('series_and_number_pasport'))
        <span class="help-block">
                <strong>{{ $errors->first('series_and_number_pasport') }}</strong>
        </span>
        @endif
        <input type="text" name="series_and_number_pasport" value="{{old('series_and_number_pasport')?old('series_and_number_pasport'):$project->requisites->series_and_number_pasport}}">
        <label>{{trans('createproject.passportwho')}}</label>
        @if ($errors->has('issued_by_passport'))
        <span class="help-block">
                <strong>{{ $errors->first('issued_by_passport') }}</strong>
        </span>
        @endif
        <input type="text" name="issued_by_passport" value="{{old('issued_by_passport')?old('issued_by_passport'):$project->requisites->issued_by_passport}}">
        <label>{{trans('createproject.passportwhen')}}</label>
        @if ($errors->has('date_issued'))
        <span class="help-block">
                <strong>{{ $errors->first('date_issued') }}</strong>
        </span>
        @endif
        <input type="date" name="date_issued" value="{{old('date_issued')?old('date_issued'):$project->requisites->date_issued}}">
        <label for="">{{trans('createproject.needdoc')}}</label>
        <!--div class="media_profile">

                @if($project->requisites->galleries)
                    @foreach( $project->requisites->galleries as $gallery)
                        <img src="{{ asset($gallery->image)}} " height="88" width="94" alt="">
                    @endforeach
                @endif
                <div class="clearfix"></div>
                <a href="#"><img src="{{asset('images/front/add_photo.png')}}" alt=""></a> 
                <div class="media_profile_info">
                        <input type="file" name="requisities_image[]" multiple="true">
                        {!!trans('createproject.docparam')!!}
                </div>
        </div-->
        
        <div class="file-loading">
            <input id="requisities_image" name="requisities_image[]" multiple type="file" accept="image/*">
        </div> 
        
        <p class="descriptioncreateproject">{!!trans('createproject.dneeddock')!!}</p>
        <label>{{trans('createproject.bankcode')}}<img src="{{asset('images/front/tooltip.png')}}" alt="" data-toggle="tooltip" data-placement="right" class="bg-tooltip" title='{{trans('createproject.qbankcode')}}'></label>
        @if ($errors->has('code_bank'))
        <span class="help-block">
                <strong>{{ $errors->first('code_bank') }}</strong>
        </span>
        @endif
        <input type="text" name="code_bank" value="{{old('code_bank')?old('code_bank'):$project->requisites->code_bank}}">
        <label>{{trans('createproject.rahunok')}}<img src="{{asset('images/front/tooltip.png')}}" alt="" data-toggle="tooltip" data-placement="right" class="bg-tooltip" title='{{trans('createproject.qrahunok')}}'></label>
        @if ($errors->has('сhecking_account'))
        <span class="help-block">
                <strong>{{ $errors->first('сhecking_account') }}</strong>
        </span>
        @endif
        <input type="text" name="сhecking_account"  value="{{old('сhecking_account')?old('сhecking_account'):$project->requisites->сhecking_account}}">
        <label>{{trans('createproject.other')}}<img src="{{asset('images/front/tooltip.png')}}" alt="" data-toggle="tooltip" data-placement="right" class="bg-tooltip" title='{{trans('createproject.qother')}}'></label>
        <input type="text" name="other" value="{{old('other')?old('other'):$project->requisites->other}}">
        <div class="buttons_project">
                <button type="submit" class="btn project_save">{{trans('createproject.saveprojectdet')}}<!-- <i class="fa fa-chevron-right"></i> --></button>
        </div>
</form>
													