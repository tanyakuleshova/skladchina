@extends('admin.layouts.admin-app')
@section('admin_content')
    <div class="wrapper wrapper-content animated fadeInDownBig">
        <div class="row">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <div class="col-md-4">
                        <h5>Статические страницы</h5>
                    </div>
                    <div class="col-md-4 pull-right">
                        <a class="btn btn-primary pull-right" href="{{ route('a_s_page.create') }}">Добавить страницу</a>
                    </div>
                </div>
                <div class="ibox-content">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>№</th>
                            <th>Ссылка</th>
                            <th>Название</th>
                            <th>Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($pages as $page)
                            <tr>
                                <td>{{ $page->id }}</td>
                                <td>{{ route('show_static_page',$page->slug)}}</td>
                                <td>{{ $page->name }}</td>
                                <td>
                                    <a data-toggle="modal" class="btn btn-primary btn_edit"
                                       href="{{ route('a_s_page.edit',$page->id) }}">Редактировать</a>

                                    <form class="form-inline btn_del"
                                          action="{{ route('a_s_page.destroy',$page->id) }}" method="post">
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
                    {{ $pages->links() }}
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