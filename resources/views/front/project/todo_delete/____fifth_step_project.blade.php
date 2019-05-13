@extends('layouts.app')
@section('style')
<link href="{{asset('administrator/css/plugins/summernote/summernote.css')}}" rel="stylesheet">
<link href="{{asset('administrator/css/plugins/summernote/summernote-bs3.css')}}" rel="stylesheet">
@endsection
@section('content')
<div class="wrap">
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="create_title"><span class="greeny">{{trans('createproject.createprj')}}</h2>
                </div>
            </div>
        </div>
    </section>
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
                                                    <button class="btn project_save">{{$project->requisites?'Змінити':'Обрати'}}</button>
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
                                                @component('front.project.5_step_fop_form',['project'=>$project])
                                                @endcomponent

                                                @component('front.project.5_step_prev_next_btn',['project'=>$project])
                                                @endcomponent
                                            </div>
                                        </div>
                                    </div>
                                    @elseif($project->requisites->type_proj === 'individual')
                                    <!-- Вывод формы для юр. лиц -->
                                    <div role="tabpanel" class="tab-pane active" id="tab_radio_2">
                                        <div class="row">
                                            <div class="col-md-12">
                                                @component('front.project.5_step_individual_form',['project'=>$project])
                                                @endcomponent

                                                @component('front.project.5_step_prev_next_btn',['project'=>$project])
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
                                                @component('front.project.5_step_entity_form',['project'=>$project])
                                                @endcomponent

                                                @component('front.project.5_step_prev_next_btn',['project'=>$project])
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
                                    {{trans('createproject.rolesfopdoctext')}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@section('script')
<script src="{{asset('administrator/js/plugins/summernote/summernote.min.js')}}"></script>
<script>
$(document).ready(function () {

    $('.summernote').summernote();

});
</script>
@endsection
