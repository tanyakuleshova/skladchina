@extends('layouts.app')
@section('title','Реквизиты')
@section('style')
<link href="{{asset('administrator/css/plugins/summernote/summernote.css')}}" rel="stylesheet">
<link href="{{asset('administrator/css/plugins/summernote/summernote-bs3.css')}}" rel="stylesheet">


<link href="{{asset('css/fileinput.css')}}" media="all" rel="stylesheet" type="text/css" />

@endsection
@section('content')
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                {!!trans('createproject.headerzag')!!}
            </div>
        </div>
    </div>
</section>

<section class="create_tabs">
    <div class="wide-border">
        @include('front.project.show_steps.navigation_steps',['nstep'=>5,'project'=>$project])
    </div>
    <div class="container">
        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="tab5">
                <div class="row">
                    <div class="col-md-8">
                        <div class="create_project create_score">
                                <!-- <section> -->								
                            <div class="wide-border">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tab nav-justified create_tab" role="tablist">
                                    <div class="form-group">
                                        @if ($errors->has('type_proj'))
                                        <div class="alert alert-danger">
                                            <strong>{{ $errors->first('type_proj') }}</strong>
                                        </div>
                                        @endif
                                        <form class="radiobutton score" action="{{route('project_type_req',$project->id)}}" method="post">
                                            {{csrf_field()}}
                                            <input type="radio" name="type_proj" value="FOP" {{($project->requisites && $project->requisites->type_proj == 'FOP')?'checked="checked"':''}}>
                                            <label for="tepy_proj">{{trans('createproject.fizosoba')}}</label>
                                            <input type="radio" name="type_proj" value="individual" {{($project->requisites && $project->requisites->type_proj == 'individual')?'checked="checked"':''}}>
                                            <label for="tepy_proj">{{trans('createproject.urosoba')}}</label>
                                            <input type="radio" name="type_proj" value="entity" {{($project->requisites && $project->requisites->type_proj == 'entity')?'checked="checked"':''}}>
                                            <label for="tepy_proj">{{trans('createproject.fop')}}</label>
                                            <div class="buttons_project">
                                                <button class="btn project_save">{{$project->requisites?'':''}}{{trans('createproject.changefop')}}</button>
                                            </div>
                                        </form>
                                    </div>
                                </ul>
                            </div>
                            @if(!$project->requisites)
                            @else
                            <h3>
                                @if($project->requisites->type_proj == 'FOP')
                                {{trans('createproject.fizosoba')}}
                                @elseif($project->requisites->type_proj == 'individual')
                                {{trans('createproject.urosoba')}}
                                @else
                                {{trans('createproject.fop')}}
                                @endif
                            </h3>
                            @endif
                            @if($project->requisites)
                            <!-- Tab panes -->
                            <div>
                                @if($project->requisites->type_proj === "FOP")
                                <!-- Вывод формы для физ. лиц -->
                                <div role="tabpanel" class="tab-pane active" id="tab_radio_1">
                                    <div class="row">
                                        <div class="col-md-12">
                                            @component('front.project.show_steps.5_step_fop_form',['project'=>$project])
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>
                                @elseif($project->requisites->type_proj === 'individual')
                                <!-- Вывод формы для юр. лиц -->
                                <div role="tabpanel" class="tab-pane active" id="tab_radio_2">
                                    <div class="row">
                                        <div class="col-md-12">
                                            @component('front.project.show_steps.5_step_individual_form',['project'=>$project])
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>
                                <!-- //////// -->
                                @else
                                <!-- Вывод формы для предпринимателей -->
                                <div role="tabpanel" class="tab-pane active" id="tab_radio_3">
                                    <div class="row">
                                        <div class="col-md-12">
                                            @component('front.project.show_steps.5_step_entity_form',['project'=>$project])
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                            @endif
                            <!-- </section> -->
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="create_section_rules">
                            <div class="description">
                                <h3>{{trans('createproject.rolesfopdoczag')}}</h3>
                                {!!trans('createproject.rolesfopdoctext')!!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('script')
<script src="{{asset('administrator/js/plugins/summernote/summernote.min.js')}}"></script>

<script src="{{asset('js/plugins/piexif.min.js')}}" type="text/javascript"></script>
<script src="{{asset('js/plugins/sortable.min.js')}}" type="text/javascript"></script>
<script src="{{asset('js/plugins/purify.min.js')}}" type="text/javascript"></script>
<script src="{{asset('js/fileinput.min.js')}}" type="text/javascript"></script>
<script src="{{asset('js/locales/ru.js')}}" type="text/javascript"></script>

<script>
$(document).ready(function () {

    //$('.summernote').summernote();

});
</script>
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
});
</script>


		
<script>
    
$("#requisities_image").fileinput({
    uploadUrl: "{{ route('downloadFileReq',$project->id) }}",
    maxFileCount: 10,
    language:'ru',
    showUpload: false,
    showRemove: false,
    validateInitialCount: true,
    overwriteInitial: false,
            @if($project->requisites->galleries)
        initialPreview: [            
                @foreach( $project->requisites->galleries as $gallery)

                    "<img class='kv-preview-data file-preview-image' src='{{ asset($gallery->image)}}'>",        
                @endforeach
        ],       
            @endif
            @if($project->requisites->galleries)
        initialPreviewConfig: [         
                @foreach( $project->requisites->galleries as $gallery)

                    {url: "{{ route('deleteFileReq',$project->id) }}", key: {{$gallery->id}} } ,        
                @endforeach
        ],       
            @endif   
    allowedFileExtensions: ["jpg", "png", "gif"]
});

</script>
@endsection
