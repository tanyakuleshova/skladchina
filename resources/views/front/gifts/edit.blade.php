<h4 class="with_present">{{trans('createproject.presentdescr')}}</h4>
<form action="{{route('ugift.update',$gift->id)}}" method="post" enctype="multipart/form-data" data-id='{{$gift->id}}' class="rewards_popup">
    {{ method_field('PUT') }}
    @if (!(isset($ajax) && $ajax))
    {{csrf_field()}}
    @endif
    <input name="project_id" type="hidden" value="{{$project_id}}"/>
    
    <label>{{trans('createproject.namegift')}}</label>
    @if ($errors->has('name'))
    <span class="help-block">
        <strong>{{ $errors->first('name') }}</strong>
    </span>
    @endif
    <input type="text" 
           name="name"
           maxlength="130" 
           class="js_counter_symbol" 
           placeholder="{{trans('createproject.namegift')}}" 
           value="{{ isset($name)?$name:$gift->name}}" 
           required="required">
    <div class="input-group-addon js_counter_symbol_counter"></div>
    <div class="clearfix"></div>
    
    <label>{{trans('createproject.needsumm')}}</label>
    @if ($errors->has('need_sum'))
    <span class="help-block">
        <strong>{{ $errors->first('need_sum') }}</strong>
    </span>
    @endif
    <input type="number" name="need_sum" placeholder="грн." value="{{ isset($need_sum)?$need_sum:$gift->need_sum}}">
    <div class="clearfix"></div>
    
    <label>{{trans('createproject.presentreview')}}</label>
    @if ($errors->has('description'))
    <span class="help-block">
        <strong>{{ $errors->first('description') }}</strong>
    </span>
    @endif
    
    <textarea rows="4" 
          name="description" 
          maxlength="500" 
          class="js_counter_symbol"
          placeholder="{{trans('createproject.shotdesc')}}">{{ isset($description)?$description:$gift->description}}</textarea>
    <div class="input-group-addon js_counter_symbol_counter"></div>
    
    <p class="descriptioncreateproject">{{trans('createproject.qpresentreview')}}</p>
    <div class="clearfix"></div>
        
    
    <div class="limitpresent">
        <label>{{trans('createproject.limitpresent')}}
            <img src="{{asset('images/front/tooltip.png')}}" alt="" data-toggle="tooltip" data-placement="right" class="bg-tooltip" title='{{trans('createproject.qlimit')}}'>
            <input type="checkbox" id='js_checkbox_limit_edit'>
        </label>
        <p class="descriptioncreateproject">{{trans('createproject.qlimitcheck')}}</p>
    </div>
    
    <div id='js_checkbox_limit_div_edit' class="hidden">
        @if ($errors->has('limit'))
        <span class="help-block">
            <strong>{{ $errors->first('limit') }}</strong>
        </span>
        @endif
        <input type="number" name="limit" class="input_limit" placeholder="0" min="0" value="{{ isset($limit)?$limit:$gift->limit}}">
    </div>
    
    <div class="clearfix"></div>
    
    <label>{{trans('createproject.dateapresent')}}</label>
    @if ($errors->has('duration'))
    <span class="help-block">
        <strong>{{ $errors->first('duration') }}</strong>
    </span>
    @endif
    <div class="create_present_date">
        <input type="number" max="50" name="duration" value="{{ isset($duration)?$duration:$gift->duration}}">
    </div>
    <div class="clearfix"></div>
    
    <label>{{trans('createproject.howdelivery')}}</label>
    @if ($errors->has('delivery_method'))
    <span class="help-block">
        <strong>{{ $errors->first('delivery_method') }}</strong>
    </span>
    @endif

    <select name="delivery_method">
        @foreach($deliveries as $method)
            <option value="{{ $method->id }}" {{ isset($delivery_method)==$method->id?'selected':($gift->delivery_id==$method->id?'selected':'') }}>{{ $method->name }}</option>
        @endforeach
    </select>
    <div class="clearfix"></div>

    <label>{{trans('createproject.posterpres')}}</label>
    <div class="media_profile">
        <div  id='update_gift' style='max-width:95px;'>
            <img src="{{asset($gift->image)}}" alt="" >
        </div>
        <div class="media_profile_info">
            <input type="file" name="image_gifts" accept="image/jpeg,image/png" id="image_gifts_edit">
            {!!trans('createproject.paramphoto')!!}
        </div>
    </div>
    @if ($errors->has('image_gifts'))
    <span class="help-block">
        <strong>{{ $errors->first('image_gifts') }}</strong>
    </span>
    @endif
    <div class="clearfix"></div>
    
    <label>{{trans('createproject.questionuser')}}</label>
    @if ($errors->has('question_user'))
    <span class="help-block">
        <strong>{{ $errors->first('question_user') }}</strong>
    </span>
    @endif
    <input type="text" name="question_user" value="{{ isset($question_user)?$question_user:$gift->question_user}}" required>
    
    <div class="modal-footer">
        <button type="submit" class="btn update_present_btn">{{trans('createproject.savepres')}}</button>
        <button type="button" class="btn" data-dismiss="modal">{{trans('createproject.closegift')}}</button>
      </div>
</form>
<script type="text/javascript">
    $(document).ready(function () {

            $('#update_gift').imagepreview({
                input: '#image_gifts_edit',
                reset: '#reset1',
                preview: '#update_gift',
                mwidth : 94,
                mheight: 88,
            });
            
        $('.summernote').summernote();
        $('input[type="checkbox"], select').styler();
        $('[data-toggle="tooltip"]').tooltip(); 

        $('#js_checkbox_limit_edit').off();
        $('#js_checkbox_limit_edit').on("click", function(){
                $('#js_checkbox_limit_div_edit').toggleClass("hidden");
        });
        $('.js_counter_symbol').each(function(){ $(this).keyup(); });
    });
</script>
