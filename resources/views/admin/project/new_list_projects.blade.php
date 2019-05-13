@extends('admin.layouts.admin-app')
@section('admin_content')
    <div class="wrapper wrapper-content animated fadeInUp">

        <div class="ibox">
            <div class="ibox-title">
                <h5>Список всех проектов направленных на проверку </h5>
            </div>
            <div class="ibox-content">
                <div class="project-list">

                    <table class="table table-hover">
                        <tbody>
                        @foreach($projects as $project)
                            <tr>
                                <td class="project-status">
                                    <span class="label label-danger">На проверке</span>
                                </td>
                                <td class="project-title">
                                    <a href="#">{{$project->name}}</a>
                                    <br/>
                                    <small>Создано {{$project->created_at}}</small>
                                </td>
                                <td class="project-completion">
                                    <small>Автор</small>
                                    <div class="project">
                                        <div> {{$project->author->name.' '.$project->author->last_name}}</div>
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
                                    <a href="#" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i>
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