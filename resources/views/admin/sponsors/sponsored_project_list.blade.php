@extends('admin.layouts.admin-app')
@section('admin_content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Список проектов, спонсированных пользователями</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table id="sponsored-table" class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Статус</th>
                                    <th>Проект</th>
                                    <th>Сумма</th>
                                    <th>Дата создания</th>
                                    <th>Дата обновления</th>
                                    <th>Действия</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($projects as $project)
                                    <tr class="gradeX">
                                        <td>{{ $project->statusName }}</td>
                                        <td>{{ $project->name }}</td>
                                        <td>{{ $project->orders->where('status_id', 3)->sum('summa') }}</td>
                                        <td>{{ $project->created_at }}</td>
                                        <td>{{ $project->updated_at }}</td>
                                        <td><a href="{{ route('sponsored_statistics.show',$project->id) }}" 
                                               class="btn btn-info">Детальнее</a>
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
    </div>
@endsection
@section('admin_script')
    <script src="{{asset('administrator/js/plugins/dataTables/datatables.min.js')}}"></script>
    <script>
        
        $(document).ready(function () {
            $('#sponsored-table').DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    {extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'ExampleFile'},
                    {extend: 'pdf', title: 'ExampleFile'},
                ]

            });
        });

    </script>
@endsection