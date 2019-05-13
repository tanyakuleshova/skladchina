@extends('admin.layouts.admin-app')
@section('admin_content')


<div class="wrapper wrapper-content fadeInDownBig">
    <div class="row">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Заявки на выплаты</h5>
            </div>
            <div class="ibox-content">
                <table class="table dataTables-example">
                    <thead>
                        <tr>
                            <th>№</th>
                            <th>Пользователь</th>
                            <th>E-mail</th>
                            <th>Сумма</th>
                            <th>Тип</th>
                            <th>Статус</th>
                            <th>Создана</th>
                            <th>Админ</th>
                            <th>Обновлена</th>
                            <th>&nbsp;&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>   
                        @foreach($rlist as $operation)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>{{ $operation->user->fullName }}</td>
                            
                            <td>{{ $operation->user->email }}</td>

                            <td>{{ $operation->summa }}</td>


                            <td>{{ $operation->userpaymethod->name }}</td>

                            <td>{{ $operation->status->name }}</td>


                            <td>{{ $operation->created_at }}</td>

                            <td>{{ $operation->admin?$operation->admin->name:'-no-' }}</td>
                            
                            <td>{{ $operation->admin?$operation->updated_at:'-no-' }}</td>

                            <td>
                                <a class="btn btn-primary btn_show"
                                   href="{{ route('a_refund.show',$operation->id) }}"
                                   title="Просмотреть детальную информацию"><i class="fa fa-eye" aria-hidden="true"></i></a>
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