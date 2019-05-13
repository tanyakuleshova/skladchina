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
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($projects as $project)
                            <tr>
                                <td class="project-status">
                                    <span class="label label-danger">{{ $project->statusName }}</span>
                                </td>
                                <td class="project-title">
                                    <a href="{{route('a_modprojects.show',$project->id)}}">{{$project->name}}</a>
                                </td>
                                <td class="small">{{$project->created_at}}</td>
                                <td class="small">{{$project->updated_at}}</td>
                                <td class="project-completion">
                                    <small>Автор</small>
                                    <div class="project">
                                        <div><a href="{{route('users.show',$project->author->id)}}"> {{$project->author->name.' '.$project->author->last_name}}</a></div>
                                    </div>
                                </td>
                                <td class="project-actions">
                                    <a href="{{route('a_modprojects.show',$project->id)}}" class="btn btn-info btn-sm">
                                        <i class="fa fa-eye" aria-hidden="true"></i></a>    
                                        
                                    <a href="{{route('a_mod_user_project',$project->id)}}" target="_blank" class="btn btn-danger btn-sm">
                                        <i class="fa fa-spinner fa-spin fa-fw"></i></a> 
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
        function checkDelete() {
            return confirm('Вы уверены ?');
        }
    </script>
@endsection