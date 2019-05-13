@extends('admin.layouts.admin-app')
@section('admin_content')
<div class="wrapper wrapper-content animated fadeInUp">

    <div class="ibox">
        <div class="ibox-title">
            <h5>Список проектов НА РАССМОТРЕНИИ</h5>
        </div>
        <div class="ibox-content">
            <div class="project-list">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-example">
                        <thead>
                            <tr>
                                <th>Статус</th>
                                <th>Проект</th>
                                <th>Собрал</th>
                                <th>Обновлён</th>
                                <th>Автор</th>
                                <th>Админ</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($projects as $project)
                            <tr>
                                <td class="project-status">
                                    <span class="label label-danger">{{ $project->statusName }}</span>
                                </td>
                                <td class="project-title">{{$project->name}}</td>
                                <td class="small">{{ $project->getActualSumm() }}грн. / {{  round($project->projectProcent(),2) }}%</td>
                                <td class="small">{{$project->updated_at}}</td>
                                <td class="project-completion">
                                    <small>Автор</small>
                                    <div class="project">
                                        <div><a href="{{route('users.show',$project->author->id)}}"> {{$project->author->name.' '.$project->author->last_name}}</a></div>
                                    </div>
                                </td>
                                <td class="project-completion">
                                    <small>Админ</small>
                                    <div class="project">
                                        <div>{{$project->admin?$project->admin->fullName:'-'}}</div>
                                    </div>
                                </td>
                                <td class="project-actions">
                                    <a href="{{route('a_postmodprojects.show',$project->id)}}" 
                                       class="btn btn-info btn-sm pull-left"
                                       title="Управление">
                                        <i class="fa fa-eye" aria-hidden="true"></i></a>

                                    <a href="{{route('project.show',$project->id)}}"
                                       target="_blank" 
                                       class="btn btn-danger btn-sm pull-right"
                                       title="Перейти на проект">
                                        <i class="fa fa-external-link" aria-hidden="true"></i></a> 
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