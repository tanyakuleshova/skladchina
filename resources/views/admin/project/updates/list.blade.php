@extends('admin.layouts.admin-app')
@section('admin_content')
<div class="wrapper wrapper-content animated fadeInUp">

    <div class="ibox">
        <div class="ibox-title">
            <h5>Список обновлений к проектам Dremstarter</h5>
        </div>
        <div class="ibox-content">
            <div class="project-list">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-example">
                        <thead>
                            <tr>
                                <th>Статус обновления</th>
                                <th>Проект</th>
                                <th>Краткое описание</th>
                                <th>Создан</th>
                                <th>Обновлён</th>
                                <th>Автор</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($updates as $upd)
                            <tr>
                                <td class="small">{{ $upd->status->name }}</td>
                                <td class="title"><a href="{{route('a_allprojects.show',$upd->project->id)}}">{{$upd->project->name}}</a></td>
                                <td>{{ str_limit($upd->shotDesc,40) }}</td>
                                <td class="small">{{$upd->created_at}}</td>
                                <td class="small">{{$upd->updated_at}}</td>
                                <td class="project-completion">
                                    <small>Автор</small>
                                    <div class="project">
                                        <div><a href="{{route('users.show',$upd->user->id)}}"> {{$upd->user->fullName }}</a></div>
                                    </div>
                                </td>
                                <td class="project-actions">
                                    <a href="{{route('a_updates.show',$upd->id)}}" class="btn btn-info btn-sm">
                                        <i class="fa fa-eye" aria-hidden="true"></i></a>                                   
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
                    {extend: 'csv', title: 'Projects_Updates'},
                    {extend: 'excel', title: 'Projects_Updates'},
                    {extend: 'pdf', title: 'Projects_Updates'}
                ]

            });
        });
        function checkDelete() {
            return confirm('Вы уверены ?');
        }
    </script>
@endsection