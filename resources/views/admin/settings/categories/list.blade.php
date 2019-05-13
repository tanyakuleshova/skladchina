@extends('admin.layouts.admin-app')
@section('admin_content')
    <div class="wrapper wrapper-content animated fadeInDownBig">
        <div class="row">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Категории проектов</h5>
                    <div class="col-md-4 pull-right">
                        <a class="btn btn-primary pull-right" href="{{ route('catgories_project.create') }}">Добавить категорию</a>
                    </div>
                </div>
                <div class="ibox-content">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>№</th>
                            <th>Название</th>
                            <th>Описание</th>
                            <th>Действия</th>
                        </tr>
                        </thead>
                        <tbody>   
                        @foreach($categories as $category)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $category->langcur->isEmpty()?'--old?--> '.$category->name:$category->langcur->first()->name}}</td>
                                <td>{{ str_limit($category->langcur->isEmpty()?'--old?--> '.$category->description:$category->langcur->first()->description,100) }}</td>
                                <td>
                                    <a data-toggle="modal" class="btn btn-primary btn_edit"
                                       href="{{route('catgories_project.edit',$category->id)}}">Редактировать</a>
                                    </div>
                                    <form class="form-inline btn_del"
                                          action="{{route('catgories_project.destroy',$category->id)}}" method="post">
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
                </div>
            </div>
        </div>
    </div>
@endsection
@section('admin_script')
    <script>
        function checkDelete() {
            return confirm('Вы уверены что хотите удалить категорию ?');
        }
    </script>
@endsection