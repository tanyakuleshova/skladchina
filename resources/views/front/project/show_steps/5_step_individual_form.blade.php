{{-- это юридическая фирма  --}}
<form action="{{route('individual_project_form',$project->id)}}"
      method="post" enctype="multipart/form-data">
    {{csrf_field()}}
    <label>{{trans('createproject.posada')}}<img src="{{asset('images/front/tooltip.png')}}" alt="" data-toggle="tooltip" data-placement="right" class="bg-tooltip" title='{{trans('createproject.qposada')}}'></label>
    @if ($errors->has('position'))
    <span class="help-block">
        <strong>{{ $errors->first('position') }}</strong>
    </span>
    @endif
    <input type="text" name="position" value="{{old('position')?old('position'):$project->requisites->position}}">
    <label>{{trans('createproject.pib')}}<img src="{{asset('images/front/tooltip.png')}}" alt="" data-toggle="tooltip" data-placement="right" class="bg-tooltip" title='{{trans('createproject.qfio')}}'></label>
    @if ($errors->has('FIO'))
    <span class="help-block">
        <strong>{{ $errors->first('FIO') }}</strong>
    </span>
    @endif
    <input type="text" name="FIO" value="{{old('FIO')?old('FIO'):$project->requisites->FIO}}">
    <label>{{trans('createproject.nameorganisation')}}</label>
    @if ($errors->has('name_organ'))
    <span class="help-block">
        <strong>{{ $errors->first('name_organ') }}</strong>
    </span>
    @endif
    <input type="text" name="name_organ" value="{{old('name_organ')?old('name_organ'):$project->requisites->name_organ}}">
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
    <label>{{trans('createproject.edrpou')}}</label>
    @if ($errors->has('inn_or_rdpo'))
    <span class="help-block">
        <strong>{{ $errors->first('inn_or_rdpo') }}</strong>
    </span>
    @endif
    <input type="text" name="inn_or_rdpo" value="{{old('inn_or_rdpo')?old('inn_or_rdpo'):$project->requisites->inn_or_rdpo}}">

    <label>{{trans('createproject.scandoc')}}</label>
    
    <!--div class="media_profile">
        @if($project->requisites->galleries)
            @foreach( $project->requisites->galleries as $gallery)
                <img src="{{ asset($gallery->image)}} " height="88" width="94" alt="">
            @endforeach
        @endif
        <div class="clearfix"></div>
        <a href="#"><img src="{{asset('images/front/add_photo.png')}}" alt=""></a>
        @if ($errors->has('requisities_image'))
        <span class="help-block">
            <strong>{{ $errors->first('requisities_image') }}</strong>
        </span>
        @endif
        <div class="media_profile_info">
            <div class="add_present_btn">
                <input type="file" name="requisities_image[]" multiple="true">
                {!!trans('createproject.docparam')!!}
            </div>
        </div>
    </div-->
    
    <div class="file-loading">
        <input id="requisities_image" name="requisities_image[]" multiple type="file" accept="image/*">
    </div> 
    
    <p class="descriptioncreateproject">{!!trans('createproject.orgneeddock')!!}</p>

    <label>{{trans('createproject.uradress')}}</label>
    @if ($errors->has('legal_address'))
    <span class="help-block">
        <strong>{{ $errors->first('legal_address') }}</strong>
    </span>
    @endif
    <input type="text" name="legal_address" value="{{old('legal_address')?old('legal_address'):$project->requisites->legal_address}}">

    <label>{{trans('createproject.factadress')}}</label>
    @if ($errors->has('physical_address'))
    <span class="help-block">
        <strong>{{ $errors->first('physical_address') }}</strong>
    </span>
    @endif
    <input type="text" name="physical_address" value="{{old('physical_address')?old('physical_address'):$project->requisites->physical_address}}">
    <label>{{trans('createproject.bankcode')}}<img src="{{asset('images/front/tooltip.png')}}" alt="" data-toggle="tooltip" data-placement="right" class="bg-tooltip" title='{{trans('createproject.qbankcode')}}'></label>
    @if ($errors->has('code_bank'))
    <span class="help-block">
        <strong>{{ $errors->first('code_bank') }}</strong>
    </span>
    @endif
    <input type="number" name="code_bank" value="{{old('code_bank')?old('code_bank'):$project->requisites->code_bank}}">
    <label>{{trans('createproject.rahunok')}}<img src="{{asset('images/front/tooltip.png')}}" alt="" data-toggle="tooltip" data-placement="right" class="bg-tooltip" title='{{trans('createproject.qrahunok')}}'></label>
    @if ($errors->has('сhecking_account'))
    <span class="help-block">
        <strong>{{ $errors->first('сhecking_account') }}</strong>
    </span>
    @endif
    <input type="text" name="сhecking_account" value="{{old('сhecking_account')?old('сhecking_account'):$project->requisites->сhecking_account}}">
    <label>{{trans('createproject.other')}}<img src="{{asset('images/front/tooltip.png')}}" alt="" data-toggle="tooltip" data-placement="right" class="bg-tooltip" title='{{trans('createproject.qother')}}'></label>
    <input type="text" name="other" value="{{old('other')?old('other'):$project->requisites->other}}">
    <div class="buttons_project">
        <button type="submit" class="btn project_save">{{trans('createproject.saveprojectdet')}}<!-- <i class="fa fa-chevron-right"></i> --></button>  
    </div>
</form>
