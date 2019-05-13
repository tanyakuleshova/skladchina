@extends('admin.layouts.admin-app')
@section('admin_content')
    <div class="wrapper wrapper-content animated fadeInDownBig">
        <div class="row">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <div class="col-md-4">
                        <h5>Города</h5>
                    </div>
                    <div class="col-md-4 pull-right">
                        <a class="btn btn-primary pull-right" href="{{ route('cities.create') }}">Добавить город</a>
                    </div>
                </div>
                <div class="ibox-content">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>№</th>
                            <th>Название</th>
                            <th>Язык</th>
                            <th>Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($cities as $city)
                            <tr>
                                <td>{{ $city->id }}</td>
                                <td>{{ $city->description->name }}</td>
                                <td>{{ $city->description->language }}</td>
                                <td>
                                    <a data-toggle="modal" class="btn btn-primary btn_edit"
                                       href="{{ route('cities.edit',$city->id) }}">Редактировать</a>

                                    <form class="form-inline btn_del"
                                          action="{{ route('cities.destroy',$city->id) }}" method="post">
                                        <input type="hidden" name="_method" value="DELETE">
                                        {{csrf_field()}}
                                        <button type="submit" class="btn btn-danger" onclick="return checkDelete()">
                                            Удалить
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $cities->links() }}
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