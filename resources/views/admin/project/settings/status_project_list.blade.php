@extends('admin.layouts.admin-app')
@section('admin_content')
    <div class="wrapper wrapper-content animated flipInX">
        <div class="row">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Статусы проектов</h5>
                </div>
                <div class="ibox-content">
                    <div class="text-center">
                        <a data-toggle="modal" class="btn btn-primary" href="#modal-form-add-categories">Добавить</a>
                    </div>
                    <div id="modal-form-add-categories" class="modal fade" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="b-r"><h3 class="m-t-none m-b">Форма добавления категории</h3>
                                            <form action="{{route('status_projects.store')}}" method="post">
                                                {{csrf_field()}}
                                                <div class="form-group">
                                                    <label>Название</label>
                                                    <input type="text" name="name" placeholder="Введите название"
                                                           class="form-control" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Описание</label>
                                                    <textarea type="textarea" name="description" class="form-control">
                                                    </textarea>
                                                </div>
                                                <div>
                                                    <button class="btn btn-sm btn-primary pull-right m-t-n-xs"
                                                            type="submit"><strong>Сохранить</strong></button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                        <?php $i = 1; ?>
                        @foreach($status_projects as $status_project)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$status_project->name}}</td>
                                <td>{{$status_project->description}}</td>
                                <td>
                                    <a data-toggle="modal" class="btn btn-primary"
                                       href="{{'#cat-edit-'.$status_project->id}}">Редактировать</a>
                                    <div id="{{'cat-edit-'.$status_project->id}}" class="modal fade" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="b-r"><h3 class="m-t-none m-b">Форма добавления
                                                                статуса</h3>
                                                            <form action="{{route('status_projects.update',$status_project->id)}}"
                                                                  method="post">
                                                                <input type="hidden" name="_method" value="PUT">
                                                                {{csrf_field()}}
                                                                <div class="form-group">
                                                                    <label>Название</label>
                                                                    <input type="text" name="name"
                                                                           value="{{$status_project->name}}"
                                                                           class="form-control" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Описание</label>
                                                                    <textarea type="textarea" name="description"
                                                                              class="form-control">{{$status_project->description}} </textarea>
                                                                </div>
                                                                <div>
                                                                    <button class="btn btn-sm btn-primary pull-right m-t-n-xs"
                                                                            type="submit"><strong>Сохранить</strong>
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <form class="form-inline"
                                          action="{{route('status_projects.destroy',$status_project->id)}}" method="post">
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
            return confirm('Вы уверены ?');
        }
    </script>
@endsection