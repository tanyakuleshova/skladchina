@extends('admin.layouts.admin-app')
@section('admin_style')
<link href="{{asset('administrator/css/plugins/slick/slick.css')}}" rel="stylesheet">
<link href="{{asset('administrator/css/plugins/slick/slick-theme.css')}}" rel="stylesheet">
@endsection
@section('admin_content')
<div class="wrapper wrapper-content  animated fadeInDown article details_project">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="caption">ОБНОВЛЕНИЕ к проекту {{ $update->project->name }}</h2>
                </div>
            </div>
            @if($update->image)  
            <div class="row">
                <div class="col-md-12">
                    <div class="media_profile">
                        <img src="{{asset($update->image)}}" class="img-responsive">
                    </div>
                </div>
            </div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="description">
                        <label>Статус</label>
                        {{ $update->status->name  }}
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="description">
                        <label>Краткое Описание</label>
                        {!! $update->shotDesc  !!}
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="description">
                        <label>Описание</label>
                        {!! $update->text  !!}
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                @if($update->admin)
                <div class="col-md-12">
                    <div class="description">
                        <label>Администратор, проверивший обновление</label>
                        <p>{{ $update->admin->fullName }}</p>
                    </div>
                </div>
                @endif
                @if($update->admin_text)
                <div class="col-md-12">
                    <div class="description">
                        <label>Текст от администратора, {{ $update->admin?$update->admin->fullName:'' }}</label>
                        <p>{{ $update->admin_text  }}</p>
                    </div>
                </div>
                @endif
            </div>

        </div>
    </div>
    @if($update->isPending)
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">
            <form action="{{route('a_updates.update',$update->id)}}" method="post">
                {{csrf_field()}}
                {{ method_field('PUT') }}
                
                <div class="form-group">
                    <label for="action" class="control-label">Это обновление следует?</label>
                    <select class="form-control" name="action">
                        <option disabled selected>Выбирите действие</option>
                        <option value="approved">Разместить в проекте {{ $update->project->name }}</option>
                        <option value="rejected">Заблокировать</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="admin_text" class="control-label">Комментарий к обновлению :</label>
                    <input type="text" name="admin_text" class="form-control">
                </div>
                
                
                
                
                <button class="btn btn-danger pull-right">Внести изменения</button>
            </form>            
        </div>
    </div>
    @endif
    
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">
            <a class="btn btn-info pull-left" href="{{route('a_updates.index')}}">К списку обновлений</a>
        </div>
    </div>
</div>


@endsection
@section('admin_script')

<script>
    $(document).ready(function () {



    });

</script>
@endsection