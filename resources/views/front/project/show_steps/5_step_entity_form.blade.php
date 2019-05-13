{{-- это предприниматель  --}}
<form action="{{route('entity_project_form',$project->id)}}"
        method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        <label>{{trans('createproject.pib')}}<img src="{{asset('images/front/tooltip.png')}}" alt="" data-toggle="tooltip" data-placement="right" class="bg-tooltip" title='{{trans('createproject.qfio')}}'></label>
        @if ($errors->has('FIO'))
        <span class="help-block">
                <strong>{{ $errors->first('FIO') }}</strong>
        </span>
        @endif
        <input type="text" name="FIO" value="{{old('FIO')?old('FIO'):$project->requisites->FIO}}">
        <label>{{trans('createproject.cityreg')}}</label>
        @if ($errors->has('country'))
        <span class="help-block">
                <strong>{{ $errors->first('country') }}</strong>
        </span>
        @endif
        <input type="text" name="country" value="{{old('country')?old('country'):$project->requisites->country_register}}">
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
        @if ($errors->has('code'))
        <span class="help-block">
                <strong>{{ $errors->first('code') }}</strong>
        </span>
        @endif
        <input type="text" name="code" value="{{old('code')?old('code'):$project->requisites->inn_or_rdpo}}">
        
        <label>{{trans('createproject.edrpouscan')}}</label>

        <div class="file-loading">
            <input id="requisities_image" name="requisities_image[]" multiple type="file" accept="image/*">
        </div>            
        
        <p class="descriptioncreateproject">{!!trans('createproject.fopneeddock')!!}</p>
        <label>{{trans('createproject.uradress')}}</label>
        @if ($errors->has('ur_adress'))
        <span class="help-block">
                <strong>{{ $errors->first('ur_adress') }}</strong>
        </span>
        @endif
        <input type="text" name="ur_adress" value="{{old('ur_adress')?old('ur_adress'):$project->requisites->legal_address}}">
        <label>{{trans('createproject.factadress')}}</label>
        @if ($errors->has('adress'))
        <span class="help-block">
                <strong>{{ $errors->first('adress') }}</strong>
        </span>
        @endif
        <input type="text" name="adress" value="{{old('adress')?old('adress'):$project->requisites->physical_address}}">
        <label>{{trans('createproject.bankcode')}}<img src="{{asset('images/front/tooltip.png')}}" alt="" data-toggle="tooltip" data-placement="right" class="bg-tooltip" title='{{trans('createproject.qbankcode')}}'></label>
        @if ($errors->has('code_bank'))
        <span class="help-block">
                <strong>{{ $errors->first('code_bank') }}</strong>
        </span>
        @endif
        <input type="text" name="code_bank" value="{{old('code_bank')?old('code_bank'):$project->requisites->code_bank}}">
        <label>{{trans('createproject.rahunok')}}<img src="{{asset('images/front/tooltip.png')}}" alt="" data-toggle="tooltip" data-placement="right" class="bg-tooltip" title='{{trans('createproject.qrahunok')}}'></label>
        @if ($errors->has('score'))
        <span class="help-block">
                <strong>{{ $errors->first('score') }}</strong>
        </span>
        @endif
        <input type="text" name="score" value="{{old('score')?old('score'):$project->requisites->сhecking_account}}">
        <label>{{trans('createproject.other')}}<img src="{{asset('images/front/tooltip.png')}}" alt="" data-toggle="tooltip" data-placement="right" class="bg-tooltip" title='{{trans('createproject.qother')}}'></label>
        <input type="text" name="other" value="{{old('other')?old('other'):$project->requisites->other}}">
        <div class="buttons_project">
                <button type="submit" class="btn project_save">{{trans('createproject.saveprojectdet')}}<!-- <i class="fa fa-chevron-right"></i> --></button>
        </div>
</form>
