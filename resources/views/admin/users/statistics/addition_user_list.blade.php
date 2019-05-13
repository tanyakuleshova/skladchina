@extends('admin.layouts.admin-app')
@section('admin_content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Список пополнения баланса пользователей</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                <thead>
                                <tr>
                                    <th>№</th>
                                    <th>Имя Фамилия</th>
                                    <th>Email</th>
                                    <th>Сумма</th>
                                    <th>Валюта</th>
                                    <th>Номер оплаты</th>
                                    <th>Описание</th>
                                    <th>Дата</th>
                                    <th>Действия</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i=1;?>
                                @foreach($orders as $order)
                                    <tr class="gradeX">
                                        <td>{{$i}}</td>
                                        <td><a href="{{route('users.show',$order->user->id)}}">{{$order->user->name.' '.$order->user->last_name}}</a></td>
                                        <td>{{$order->user->email}}</td>
                                        <td>{{$order->transfer_sum}}</td>
                                        <td>{{$order->currency}}</td>
                                        <td>{{$order->number_inv}}</td>
                                        <td class="text-center">{!! $order->desc !!}</td>
                                        <td>{{$order->created_at}}</td>
                                        <td class="center">
                                            <form action="{{route('additions_users.destroy',$order->id)}}" method="POST">
                                                <input type="hidden" name="_method" value="DELETE">
                                                {{csrf_field()}}
                                                <button type="submit" class="btn btn-danger dim"
                                                        onclick="return checkDelete()"><i class="fa fa-trash"
                                                                                          aria-hidden="true"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php $i++?>
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