@extends('admin.layouts.admin-app')
@section('admin_content')
    <div class="wrapper wrapper-content fadeInDownBig">
        <div class="row">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Баланс. Опереции</h5>
                </div>
                <div class="ibox-content">
                    <table class="table dataTables-example">
                        <thead>
                        <tr>
                            <th>№</th>
                            <th>Пользователь</th>
                            <th>Сумма</th>
                            <th>Тип</th>
                            <th>Статус</th>
                            <th>Админ</th>
                            <th>Создана</th>
                            <th>Обновлена</th>
                            <th>&nbsp;&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>   
                        @foreach($balancies as $operation)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                
                                <td>{{ $operation->user->name }}</td>
                                
                                <td>{{ $operation->summa }}</td>
                                
                                
                                <td>{{ $operation->type->name }}</td>
                                
                                <td>{{ $operation->status->name }}</td>
                                
                                <td>{{ $operation->admin_name }}</td>
                                
                                <td>{{ $operation->created_at }}</td>
                                
                                <td>{{ $operation->updated_at }}</td>
                                
                                <td style="float: left;">
                                    <!--a class="btn btn-primary"
                                       title="Просмотреть детальную информацию"
                                       href="{{route('balance.show',$operation->id)}}"><i class="fa fa-eye" aria-hidden="true"></i></a-->
                                    @if($operation->isPending) 
                                        <form action="{{route('balance.update',$operation->id)}}"
                                              method="post">
                                            <input type="hidden" name="_method" value="PUT">
                                            <input type="hidden" name="action" value="rejected">
                                            <button type="submit" 
                                                    class="btn btn-danger"
                                                    title="Перевести в сатус Отмена."
                                                    onclick="return checkDelete()"><i class="fa fa-trash"
                                                                                      aria-hidden="true"></i>
                                            </button>
                                            {{csrf_field()}}
                                        </form>
                                    @endif
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