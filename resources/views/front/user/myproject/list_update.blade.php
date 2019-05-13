@extends('layouts.app')
@section('content')
<div class="wrapper">
    <div class="container">
        <div class="list-update"> 
            <div class="row">
                <div class="ibox-title">
                    <h2 class="caption">Обновления по проекту {{ $project->name}}</h2>
                </div>

                <div class="ibox-content">
                    @if(!$updates->isEmpty())
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>№</th>
                                <th>Создан</th>
                                <th>Картинка</th>
                                <th>Краткое описание</th>
                                <th>Статус</th>
                                <th>Проверил</th>
                                <th>Изменён</th>
                                <th>&nbsp;&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>   
                            @foreach($updates as $upd)
                            <tr>
                                <td data-label="№:">{{ $upd->id }}</td>
                                <td data-label="Создан:">{{ $upd->created_at }}</td>
                                <td data-label="Картинка:">
                                    @if($upd->image)
                                    <img src="{{ $upd->image }}" width="75" height="75"/>
                                    @endif
                                </td>
                                <td data-label="Краткое описание:">{!! strip_tags($upd->shotDesc) !!}</td>
                                <td data-label="Статус:">{{ $upd->status->name }}</td>
                                <td data-label="Проверил:">{{ $upd->admin?$upd->admin->name:'' }}</td>
                                <td data-label="Изменён:">{{ $upd->admin?$upd->updated_at:'' }}</td>
                                <td>
                                    <a href="{{route('projectup.show',$upd->id)}}?project_id={{ $project->id }}" class="btn" title="Просмотреть детальную информацию"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                    @if($upd->isPending)
                                    <form action="{{route('projectup.destroy',$upd->id)}}" method="POST" class="btn_del">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="project_id" value="{{ $project->id }}">
                                        {{csrf_field()}}
                                        <button type="submit" class="btn btn-danger" title="Удалить обновление" onclick="return checkDeleteText(' обновление ')"><i class="fa fa-trash" aria-hidden="true"></i>
                                        </button>
                                    </form>  
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $updates->links() }}
                    @else
                    <h3>У Вас нет обновлений для проекта</h3>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="update-navigation">
                    <a href="{{route('myprojects.index')}}" class="btn btn-info">Назад, Мои проекты</a>
                    <a href="{{route('projectup.create')}}?project_id={{ $project->id }}" class="btn btn-info">Создать обновление</a>
                </div>
            </div>
        </div>
    </div>
</div>  
@endsection
