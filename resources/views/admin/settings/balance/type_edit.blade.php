@extends('admin.layouts.admin-app')
@section('admin_content')
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5> Форма редактирования типа операции баланса, только описание</h5>
        </div>
        <div>
            <div class="ibox-content profile-content">
                <form action="{{ route('balance_type.update',$type->id) }}" method="POST">
                    <input type="hidden" name="_method" value="PUT">
                    {{csrf_field()}}

                    <div class="form-group">
                        <label for="status_code" class="control-label">Code</label>
                        <p id="status_code" class="form-control">{{ $type->code }}</p>
                    </div>

                    <div class="form-group">
                        <label for="name" class="control-label">Описание</label>
                        <input type="text" 
                               name="name" 
                               class="form-control" 
                               required="required"
                               value="{{ old('name')?old('name'):$type->name }}" />
                    </div>

                    <div class="user-button">
                        <div class="row">
                            <div class="col-md-2">
                                <a href="{{ route('balance_type.index') }}" type="button"
                                   class="btn btn-primary btn-sm btn-block">К списку типов операций</a>
                            </div>
                            <div class="col-md-2">
                                <button type="submit"  class="btn btn-success btn-sm btn-block">Обновить тип операции баланса</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection