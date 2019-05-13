<p class="with_present" style="text-align: center; margin: 0;">{{trans('createproject.presentdescr1')}}</p>
<h4 class="with_present">{{trans('createproject.presentdescr')}}</h4>
<form action="{{route('ugift.store')}}" method="post" enctype="multipart/form-data">
    {{csrf_field()}}
    <input name="project_id" type="hidden" value="{{$project_id}}"/>
    
    <label>{{trans('createproject.namegift')}}
        <img src="{{asset('images/front/tooltip.png')}}" alt="" data-toggle="tooltip" data-placement="right" class="bg-tooltip" title='{{trans('createproject.namegift')}}'>
    </label>
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
           required="required"
           value="{{ isset($name)?$name:""}}">
    <div class="input-group-addon js_counter_symbol_counter"></div>
    
    <label>{{trans('createproject.needsumm')}}
        <img src="{{asset('images/front/tooltip.png')}}" alt="" data-toggle="tooltip" data-placement="right" class="bg-tooltip" title='{{trans('createproject.qneedsumm')}}'>
    </label>
    @if ($errors->has('need_sum'))
    <span class="help-block">
        <strong>{{ $errors->first('need_sum') }}</strong>
    </span>
    @endif
    <input type="number" name="need_sum" placeholder="грн." value="{{ isset($need_sum)?$need_sum:""}}">
    
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
          placeholder="{{trans('createproject.shotdesc')}}">{{ isset($description)?$description:""}}</textarea>
    <div class="input-group-addon js_counter_symbol_counter"></div>
    
    <p class="descriptioncreateproject">{{trans('createproject.qpresentreview')}}</p>
    <div class="clearfix"></div>
    <div class="limitpresent">
        <label>{{trans('createproject.limitpresent')}}
            <img src="{{asset('images/front/tooltip.png')}}" alt="" data-toggle="tooltip" data-placement="right" class="bg-tooltip" title='{{trans('createproject.qlimit')}}'>
            <input type="checkbox" id='js_checkbox_limit'>
        </label>
        <h4>{{trans('createproject.qlimitcheck')}}</h4>
    </div>
    <div id='js_checkbox_limit_div' class="hidden limitpresent-value">
    @if ($errors->has('limit'))
    <span class="help-block">
        <strong>{{ $errors->first('limit') }}</strong>
    </span>
    @endif
    <input type="number" name="limit" class="input_limit" placeholder="шт." min="0" value="{{ isset($limit)?$limit:""}}">
    <p class="descriptioncreateproject">{{trans('createproject.dlimit')}}</p>
    </div>
    <div class="clearfix"></div>
    <label>{{trans('createproject.dateapresent')}}<img src="{{asset('images/front/tooltip.png')}}" alt="" data-toggle="tooltip" data-placement="right" class="bg-tooltip" title='{{trans('createproject.qdateapresent')}}'></label>
    @if ($errors->has('duration'))
    <span class="help-block">
        <strong>{{ $errors->first('duration') }}</strong>
    </span>
    @endif
    <div class="create_present_date">
        <input type="number" name="duration" placeholder="{{trans('createproject.dateapresentplaceholder')}}" max="365" value="{{ isset($duration)?$duration:""}}">
    </div>
    
    <label>{{trans('createproject.howdelivery')}}<img src="{{asset('images/front/tooltip.png')}}" alt="" data-toggle="tooltip" data-placement="right" class="bg-tooltip" title='{{trans('createproject.qhowdelivery')}}'></label>
    @if ($errors->has('delivery_method'))
    <span class="help-block">
        <strong>{{ $errors->first('delivery_method') }}</strong>
    </span>
    @endif
    
    <select name="delivery_method" class="pr_selector">
        @foreach($deliveries as $method)
            <option value="{{ $method->id }}" {{ isset($delivery_method)==$method->id?'selected':'' }}>{{ $method->name }}</option>
        @endforeach
    </select>
    
    <label>{{trans('createproject.posterpres')}}<img src="{{asset('images/front/tooltip.png')}}" alt="" data-toggle="tooltip" data-placement="right" class="bg-tooltip" title='lorem ipsum'></label>
    <div class="media_profile">
        <a href="#">
        <div  id='create_gift' height="88" width="94">
            <img src="{{asset('images/front/add_photo.png')}}" alt=""></a>
        </div>
        <div class="media_profile_info">
            <input type="file" name="image_gifts" accept="image/jpeg,image/png">
            {!!trans('createproject.paramphoto')!!}
        </div>
    </div>
    @if ($errors->has('image_gifts'))
    <span class="help-block">
        <strong>{{ $errors->first('image_gifts') }}</strong>
    </span>
    @endif
    
    <label>{{trans('createproject.questionuser')}}<img src="{{asset('images/front/tooltip.png')}}" alt="" data-toggle="tooltip" data-placement="right" class="bg-tooltip" title='{{trans('createproject.qquestionuser')}}'></label>
    @if ($errors->has('question_user'))
    <span class="help-block">
        <strong>{{ $errors->first('question_user') }}</strong>
    </span>
    @endif

    <input type="text" name="question_user" value="{{ isset($question_user)?$question_user:""}}" required>
    <p class="descriptioncreateproject">{{trans('createproject.dquestionuser')}}</p>
    <button type="submit" class="btn save_present_btn">{{trans('createproject.savepres')}}</button>
</form>
<script type="text/javascript">
    $(document).ready(function () {
            $('#create_gift').imagepreview({
                input: '[name="image_gifts"]',
                reset: '#reset1',
                preview: '#create_gift',
                mwidth : 94,
                mheight: 88,
            });
            
            $('#js_checkbox_limit').off();
            $('#js_checkbox_limit').on("click", function(){
                    $('#js_checkbox_limit_div').toggleClass("hidden");
            });
            
            @if ($errors->has('limit') || isset($limit))
                $('#js_checkbox_limit').click();
            @endif
            
            

    });
</script>
@if (!(isset($ajax) && $ajax))

<script>
    $(document).ready(function () {
        $('.summernote').summernote();
        $('input[type="checkbox"], select').styler();
        $('[data-toggle="tooltip"]').tooltip(); 
        $('.js_counter_symbol').each(function(){ $(this).keyup(); });
    });
</script>

@endif