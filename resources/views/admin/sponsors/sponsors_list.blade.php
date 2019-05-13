@extends('admin.layouts.admin-app')
@section('admin_content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Список спонсирования проектов пользователями</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table id="sponsored-table" class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Пользователь</th>
                                    <th>Проект</th>
                                    <th>Сумма, грн</th>
                                    <th>Дата обновления</th>
                                    <th>Вознаграждение</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($orders as $order)
                                    <tr class="gradeX">
                                        <td>{{ $order->user?$order->user->fullName:'' }} <a href="{{route('users.show',$order->user_id)}}" target="_blank" class="btn btn-info"><i
                                                class="fa fa-info" aria-hidden="true"></i></a></td>
                                        <td>{{ $order->project?$order->project->name:''}}</td>
                                        <td>{{ $order->summa }}</td>
                                        <td>{{ $order->updated_at }}</td>
                                        <td>{{ $order->gift?'есть, '.$order->gift->deliveryMethod:'-без-' }}</td>
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