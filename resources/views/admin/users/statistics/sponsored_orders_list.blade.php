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
                                    <th>Id</th>
                                    <th>Пользователь</th>
                                    <th>Проект</th>
                                    <th>Сумма</th>
                                    <th>Подарок</th>
                                    <th>Дата создания</th>
                                    <th>Дата обновления</th>
                                    <th>Действия</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($sponsored_orders as $sponsored_order)
                                    <tr class="gradeX">
                                        <td>{{$sponsored_order->id}}</td>
                                        <td>{{$sponsored_order->user_id}}</td>
                                        <td>{{$sponsored_order->project_id}}</td>
                                        <td>{{$sponsored_order->sum}}</td>
                                        @if($sponsored_order->project_gift_id)
                                            <td>{{$sponsored_order->project_gift_id}}</td>
                                        @else
                                            <td> --</td>
                                        @endif

                                        <td>{{$sponsored_order->created_at}}</td>
                                        <td>{{$sponsored_order->updated_at}}</td>
                                        <td>
                                            <form action="{{route('sponsored_statistics.destroy',$sponsored_order->id)}}"
                                                  method="post">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button type="submit" class="btn btn-danger dim"
                                                        onclick="return checkDelete()"><i class="fa fa-trash"
                                                                                          aria-hidden="true"></i>
                                                </button>
                                                {{csrf_field()}}
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
    <script>
        function checkDelete() {
            return confirm('Вы уверены ?');
        }
    </script>
@endsection