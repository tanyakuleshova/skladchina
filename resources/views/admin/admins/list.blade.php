@extends('admin.layouts.admin-app')
@section('admin_content')
    <div class="wrapper wrapper-content animated users_list fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Список всех АДМИНИСТРАТОРОВ</h5>
                        <a class="pull-right btn btn-warning" href="{{ route('admins.create') }}">Создать</a>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>Имя Фамилия</th>
                                    <th>Email</th>
                                    <th>Статус</th>
                                    <th>Права</th>
                                    <th>Действия</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($admins as $admin)
                                    <tr class="gradeX">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $admin->fullName }}</td>
                                        <td>{{ $admin->email}}</td>
                                        <td>{{ $admin->status }}</td>
                                        <td>{{ $admin->isAdmin?'админ':'менеджер' }}</td>
                                        <td class="center">
                                            <a href="{{route('admins.edit',$admin->id)}}" class="btn btn-warning dim"><i
                                                        class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                            <form action="{{route('admins.destroy',$admin->id)}}" method="POST" class="btn_del">
                                                <input type="hidden" name="_method" value="DELETE">
                                                {{csrf_field()}}
                                                <button type="submit" class="btn btn-danger dim"
                                                        onclick="return checkDelete()"><i class="fa fa-trash"
                                                                                          aria-hidden="true"></i>
                                                </button>
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
                    {extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'ExampleFile'},
                    {extend: 'pdf', title: 'ExampleFile'},

                    {
                        extend: 'print',
                        customize: function (win) {
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');
                            $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                        }
                    }
                ]

            });
        });
        function checkDelete() {
            return confirm('Вы уверены ?');
        }
    </script>
@endsection