@extends('admin.layouts.admin-app')
@section('admin_content')
    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Баланс. Статусы операций</h5>
                </div>
                <div class="ibox-content">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>№</th>
                            <th>code</th>
                            <th>Описание</th>
                            <th>Действия</th>
                        </tr>
                        </thead>
                        <tbody>   
                        @foreach($statuses as $status)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $status->code }}</td>
                                <td>{{ $status->name }}</td>
                                <td>
                                    <a data-toggle="modal" class="btn btn-primary btn_edit"
                                       href="{{route('balance_status.edit',$status->id)}}">Редактировать</a>
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
