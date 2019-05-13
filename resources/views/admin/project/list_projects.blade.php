@extends('admin.layouts.admin-app')
@section('admin_content')
    <div class="wrapper wrapper-content animated fadeInUp">

        <div class="ibox">
            <div class="ibox-title">
                <h5>Список всех проектов Dremstarter</h5>
                {{--<div class="ibox-tools">--}}
                    {{--<a href="№" class="btn btn-primary btn-xs">Создать проект</a>--}}
                {{--</div>--}}
            </div>
            <div class="ibox-content">
                {{--<div class="row m-b-sm m-t-sm">--}}
                {{--<div class="col-md-11">--}}
                {{--<div class="input-group"><input type="text" placeholder="Search" class="input-sm form-control">--}}
                {{--<span class="input-group-btn">--}}
                {{--<button type="button" class="btn btn-sm btn-primary"> Go!</button> </span></div>--}}
                {{--</div>--}}
                {{--</div>--}}
                <div class="project-list">

                    <table class="table table-hover">
                        <tbody>
                        @foreach($projects as $project)
                            <tr>
                                <td class="project-status">
                                    @if($project->mod_status == 2)
                                        <span class="label label-primary">Активно</span>
                                    @elseif($project->mod_status ==0)
                                        <span class="label label-info">Сохранено</span>
                                    @elseif($project->mod_status == 1)
                                        <span class="label label-danger">На проверке</span>
                                    @else
                                        <span class="label label-default">Завершено</span>
                                    @endif
                                </td>
                                <td class="project-title">
                                    <a href="{{route('admin_project.show',$project->id)}}">{{$project->name}}</a>
                                    <br/>
                                    <small>Создано {{$project->created_at}}</small>
                                </td>
                                <td class="project-completion">
                                    <small>Автор</small>
                                    <div class="project">
                                        <div><a href="{{route('users.show',$project->author->id)}}"> {{$project->author->name.' '.$project->author->last_name}}</a></div>
                                    </div>
                                </td>
                                <td class="project-people">
                                    @if($project->requisites)
                                        @if($project->requisites->galleries)
                                            @foreach($project->requisites->galleries as $gallery)
                                                <a href="#"><img alt="image" class="img-circle"
                                                                 src="{{asset($gallery->link_scan)}}"></a>
                                            @endforeach
                                        @endif
                                    @endif
                                </td>
                                <td class="project-actions">
                                    <a href="{{route('admin_project.show',$project->id)}}" class="btn btn-white btn-sm"><i
                                                class="fa fa-folder"></i>
                                        Просмотр</a>
                                    <a href="{{route('admin_project.edit',$project->id)}}" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i>
                                        Редактировать </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection