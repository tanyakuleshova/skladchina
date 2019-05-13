@extends('admin.layouts.admin-app')
@section('admin_content')
<div class="wrapper wrapper-content animated fadeInUp">

    <div class="ibox">
        <div class="ibox-title">
            <h5>Список всех проектов Dremstarter</h5>
        </div>
        <div class="ibox-content">
            <div class="project-list">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-example">
                        <thead>
                            <tr>
                                <th>Статус</th>
                                <th>Проект</th>
                                <th>Создан</th>
                                <th>Обновлён</th>
                                <th>Автор</th>
                                <th>ГРН</th>
                                <th>%</th>
                                <th>Админ</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($projects as $project)
                            <tr style="{{ $project->isClosedMod?'background: paleturquoise;':''}}">
                                <td class="project-status">
                                    
                                    @if($project->isAllEdited)
                                    <span class="label label-info">
                                    @elseif($project->isModeration)
                                    <span class="label label-danger">
                                    @elseif($project->isActive)
                                    <span class="label label-primary">
                                    @elseif($project->allClosed)
                                    <span class="label label-default">
                                    @endif
                                    {{ $project->statusName }}</span>
                                </td>
                                <td class="project-title">{{$project->name}}</td>
                                <td class="small">{{$project->created_at}}</td>
                                <td class="small">{{$project->updated_at}}</td>
                                <td class="project-completion">
                                    <small>Автор</small>
                                    <div class="project">
                                        <div><a href="{{route('users.show',$project->author->id)}}">{{ $project->author->fullName }}</a></div>
                                    </div>
                                </td>
                                <td>{{ $project->getActualSumm() }}</td>
                                <td>{{ round($project->projectProcent(),2)}}</td>
                                <td>
                                    @if($project->admin)
                                        <small>{{$project->admin->fullName }}</small>
                                    @endif
                                </td>
                                <td class="project-actions">

                                        
                                    @if($project->isModeration)
                                    <a href="{{route('a_modprojects.show',$project->id)}}" class="btn btn-info btn-sm">
                                        <i class="fa fa-eye" aria-hidden="true"></i></a> 

                                    @else
                                        <a href="{{route('a_allprojects.show',$project->id)}}" class="btn btn-info btn-sm">
                                            <i class="fa fa-eye" aria-hidden="true"></i></a> 
                                    @endif
                                    
                                    <a href="{{route('a_mod_user_project',$project->id)}}" 
                                       title="Редактировать проект, как {{ $project->author->fullName }}"
                                       target="_blank" 
                                       class="btn btn-warning btn-sm">
                                        <i class="fa fa-spinner fa-spin fa-fw"></i></a> 
                                        
                                    <form class="pull-right padding" action="{{route('a_allprojects.destroy',$project->id)}}" method="post">
                                            {{ method_field('DELETE') }}
                                            {{csrf_field()}}
                                        <button type="submit" 
                                                    title="Удалить проект"
                                                    onclick="return checkDelete('Удалить проект {{$project->name}} ?');"
                                                    class="btn btn-danger btn-sm"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                                    </form>
                                    
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('admin_script')
    <script src="{{asset('administrator/js/plugins/dataTables/datatables.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('.dataTables-example').DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    {extend: 'csv'},
                    {extend: 'excel', title: 'Projects'},
                    {extend: 'pdf', title: 'Projects'}
                ]

            });
        });
        function checkDelete(te) {
            return confirm(te);
        }
    </script>
@endsection