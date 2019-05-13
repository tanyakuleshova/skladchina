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
                    <h2 class="create_title"><span class="greeny">{!!trans('createproject.createprj')!!}</h2>
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
        @include('front.project.show_steps.navigation_steps',['nstep'=>2,'project'=>$project])
        </div>
        <div class="container">
        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="tab2">
                <div class="row">
                    <div class="col-md-8">
                        <div class="create_project create_info">
                            <div>
                                @if($project->projectVideo)
                                    @if($project->projectVideo->self_video == 0)
                                        <iframe width="560" height="315"
                                        src="{{'https://www.youtube.com/embed/'.$project->projectVideo->link_video}}"
                                        frameborder="0" allowfullscreen></iframe>
                                    @else
                                        <video width="560" height="315" controls="controls" poster="{{asset($project->poster_link)}}">
                                            <source src="{{asset('storage/'.$project->projectVideo->link_video)}}" type='video/mp4'>
                                        </video>
                                    @endif
                                    <form action="{{route('delete_project_video',$project->projectVideo->id)}}"
                                      method="get">
                                        {{csrf_field()}}
                                        <button type="submit" class="btn">{{trans('createproject.delete')}}</button>
                                    </form>
                                @endif
                            </div>
                            <form action="{{route('second_step_project',$project->id)}}" method="post" enctype="multipart/form-data">
                                {{csrf_field()}}

                                @if(!$project->projectVideo)
                                <label class="top_reset">{{trans('createproject.upvideo')}}</label>
                                <input type="text" name="video_iframe" placeholder="https://">
                                <label>{{trans('createproject.upounvideo')}}</label>
                                <div class="media_profile">
                                    <a href="#"><img src="{{asset('images/front/add_video.png')}}" alt=""></a>
                                    <div class="media_profile_info">
                                        <input type="file" name="video_user" placeholder="https://">
                                        {!!trans('createproject.paramvideo')!!}
                                    </div>
                                </div>
                                @endif
                                <h4>{!!trans('createproject.zagproject')!!}</h4>
                                <label>{{trans('createproject.describeproject')}}</label>
                                <textarea name="description" class="summernote">{{$project->description}}</textarea>
                                <h4>{!!trans('createproject.describeprojectdet')!!}</h4>
                                <!-- Реализовать форму редактирование сохраненных проектов -->
                                <div class="buttons_project">
                                    <button class="btn project_save">{{trans('createproject.saveprojectdet')}}<i class="fa fa-chevron-right"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="create_section_rules">
                            <div class="description">
                                {!!trans('createproject.rulesidefirststep')!!}
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