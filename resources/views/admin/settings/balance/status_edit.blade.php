@extends('admin.layouts.admin-app')
@section('admin_content')
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5> Форма редактирования статусов платежей, только описание</h5>
        </div>
        <div>
            <div class="ibox-content profile-content">
                <form action="{{ route('balance_status.update',$status->id) }}" method="POST">
                    <input type="hidden" name="_method" value="PUT">
                    {{csrf_field()}}

                        <div class="form-group">
                            <label for="status_code" class="control-label">Code</label>
                            <p id="status_code" class="form-control">{{ $status->code }}</p>
                        </div>
                        
                        <div class="form-group">
                            <label for="name" class="control-label">Описание</label>
                            <input type="text" 
                                   name="name" 
                                   class="form-control" 
                                   required="required"
                                   value="{{ old('name')?old('name'):$status->name }}" />
                        </div>

                   

                    <div class="user-button">
                        <div class="row">
                            <div class="col-md-2">
                                <a href="{{ route('balance_status.index') }}" type="button"
                                   class="btn btn-primary btn-sm btn-block">К списку статусов</a>
                            </div>
                            <div class="col-md-2">
                                <button type="submit"  class="btn btn-success btn-sm btn-block">Обновить описание статуса</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection