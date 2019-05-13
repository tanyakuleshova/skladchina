@extends('layouts.app')
@section('title','На модерацию')
@section('style')

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
        @include('front.project.show_steps.navigation_steps',['nstep'=>6,'project'=>$project])
    </div>
    <div class="container">
        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="tab6">
                <div class="row">

                    <div class="col-md-8">
                        <div class="create_project create_finish">
                            <div class="description">
                                {!!trans('createproject.moderationtext')!!}
                            </div>
                            <div class="create_finish_manager">
                                <img src="{{ $project->admin->avatar }}">
                            </div>
                            <h4>{{ $project->admin->fullName }}</h4>
                            <div class="mail">
                                <p>
                                    <img src="{{asset('images/front/mail.png')}}" height="12" width="15">
                                    {{ $project->admin?$project->admin->email:'...' }}
                                </p>
                            </div>
                            <div class="phone">
                                <p>
                                    <i class="fa fa-phone-square" aria-hidden="true" style="color: lightskyblue;"></i>
                                    &nbsp;&nbsp;&nbsp;&nbsp;{{ ($project->admin && $project->admin->account)?$project->admin->account->contact_phone:'...'}}
                                </p>
                            </div>

                            <div class="row">
                                @if($project->location)
                                <div class="bg-warning bg-administrator-warning">
                                    <h5>Сообщение от администратора</h5>
                                    {{ $project->location }}
                                </div>
                                @endif
                                <form class="col-xs-12 col-md-6 pull-left del-project-wrap" action="{{route('project.destroy',$project->id)}}" method="post">
                                    {{csrf_field()}}
                                    {{ method_field('DELETE') }}
                                    <button type="submit" 
                                            title="Удалить проект"
                                            onclick="return checkButtonSwalDelete(this, 'warning', 'Удалить этот проект ?');"
                                            class="btn btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i> {{trans('createproject.delproject')}}</button>
                                </form>

                                @if($project->isModeration && Auth::guard('admin')->user())
                                    <div class="col-xs-12 col-md-6 pull-right moderation-project-wrap">
                                        
                                        <div>
                                            <form action="{{route('a_modprojects.update',$project->id)}}" method="post">
                                                {{csrf_field()}}
                                                {{ method_field('PUT') }}
                                                <input type="hidden" name="action" value="approved">
                                                <button class="btn btn-danger pull-right">Опубликовать</button>
                                            </form>            
                                        </div>
                                        <div><br/><br/><br/><br/><br/><br/><br/></div>
                                        <div>
                                            <form action="{{route('a_modprojects.update',$project->id)}}" method="post">
                                                {{csrf_field()}}
                                                {{ method_field('PUT') }}
                                                <input type="hidden" name="action" value="rejected">
                                                <input type="hidden" name="admin_id" value="{{ Auth::guard('admin')->user()->id }}">
                                                <p>Администратор: {{ Auth::guard('admin')->user()->fullName }}</p>

                                                <label class="control-label" for="location">Укажите причину доработки</label>
                                                <input class="form-control" type="text" name="location" value="{{ $project->location }}">
                                                <button class="btn btn-success">Отправить на доработку</button>
                                            </form> 
                                        </div>  

                                    </div>
                                @else
                                    @if($diff_steps)
                                    <div class="col-xs-12 col-md-6 pull-right moderation-project-wrap">
                                        <button title="{{trans('createproject.sendmoderation')}} невозможно, проверьте полноту заполнения проекта."
                                                class="btn disabled">{{trans('createproject.sendmoderation')}} <i class="fa fa-location-arrow" aria-hidden="true"></i></button>
                                    </div>
                                    @else
                                    <form class="col-xs-12 col-md-6 pull-right moderation-project-wrap" action="{{route('update_project',['id'=>$project->id,'step'=>6])}}" method="post">
                                        {{csrf_field()}}
                                        {{ method_field('PUT') }}
                                        <button type="submit" 
                                                title="{{trans('createproject.sendmoderation')}}"
                                                class="btn project_moderation_btn">{{trans('createproject.sendmoderation')}} <i class="fa fa-location-arrow" aria-hidden="true"></i></button>
                                    </form>
                                    @endif
                                @endif
                            </div>



                        </div>
                    </div>

                    <div class="col-md-4 create_view">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="product_wrap create_product_wrap">
                                    @include('front.project.blocks.show_small_project_nowrap',['project'=>$project])
                                </div>
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
<script>
    $(document).ready(function () {




    });
</script>
@endsection
