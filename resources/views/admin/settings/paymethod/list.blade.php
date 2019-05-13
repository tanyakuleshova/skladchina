@extends('admin.layouts.admin-app')
@section('admin_content')
    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Платежные методы, для пользователей</h5>
                </div>
                <div class="ibox-content">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>№</th>
                            <th>Статус</th>
                            <th>Описание</th>
                            <th>Действия</th>
                        </tr>
                        </thead>
                        <tbody>   
                        @foreach($paymethods as $pm)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $pm->active?'Активен':'Не доступен' }}</td>
                                <td>{{ $pm->name }}</td>
                                <td>
                                    <a class="btn btn-primary btn_edit"
                                       href="{{route('paymethods.edit',$pm->id)}}">Редактировать</a>
                                    </div>
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
