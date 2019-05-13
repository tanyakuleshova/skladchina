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
            @include('front.project.show_steps.navigation_steps',['nstep'=>4,'project'=>$project])
        </div>
        <div class="container">
            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="tab4">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="create_project create_about">
                                <form action="{{route('profile_info')}}" method="post" enctype="multipart/form-data">
                                    {{csrf_field()}}
                                    <label class="top_reset">{{trans('createproject.socialacc')}}</label>
                                    <h4>{{trans('createproject.socialdescribe')}}</h4>
                                    <div class="social_wrap">
                                        <div class="settings_social settings_fb"></div>
                                        <input type="text" value="{{$project->author->account->social_href_facebook}}" name="sc_facebook" placeholder="https://facebook">
                                    </div>
                                    <label>{{trans('createproject.profileimg')}}</label>
                                    <div class="media_profile">
                                        <a href="#"><img src="{{asset($project->author->account->avatar_link)}}" height="88" width="94" alt=""></a>
                                        <div class="media_profile_info">
                                            <input type="file" name="profile_avatar">
                                            {!!trans('createproject.paramphoto')!!}
                                        </div>
                                    </div>
                                    <label>{{trans('createproject.aboutself')}}</label>
                                    <textarea name="about_self" rows="5">{{$project->author->account->about_self}}</textarea>
                                    <label>{{trans('createproject.yourplace')}}</label>
                                    <input type="text" name="city_birth" value="{{$project->author->account->city_birth}}">
                                    <div class="settings_contacts">
                                        <label>{{trans('createproject.site')}}</label>
                                        <input type="text" name="site" class="settings_input_site" value="{{$project->author->account->user_site}}">
                                    </div>
                                    <h4>{{trans('createproject.sitedescribe')}}</h4>
                                    <div class="buttons_project">
                                        <button class="btn project_save">{{trans('createproject.saveprojectdet')}}<i class="fa fa-chevron-right"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="create_section_rules">
                                <div class="description">
                                    {!!trans('createproject.rulesidefourthstep')!!}
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