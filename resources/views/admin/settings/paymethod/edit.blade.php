@extends('admin.layouts.admin-app')
@section('admin_content')
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5> Форма редактирования платежных методов, описание и доступность</h5>
        </div>
        <div>
            <div class="ibox-content profile-content">
                <form action="{{ route('paymethods.update',$paymethod->id) }}" method="POST">
                    <input type="hidden" name="_method" value="PUT">
                    {{csrf_field()}}

                        <div class="form-group">
                            <label for="status" class="control-label">Активен</label>
                            <input type="checkbox" 
                                   name="status" 
                                   class="form-control" 
                                   {{ $paymethod->active?'checked="checked"':'' }}
                                    />
                        </div>
                        
                        <div class="form-group">
                            <label for="name" class="control-label">Описание</label>
                            <input type="text" 
                                   name="name" 
                                   class="form-control" 
                                   required="required"
                                   value="{{ old('name')?old('name'):$paymethod->name }}" />
                        </div>

                   

                    <div class="user-button">
                        <div class="row">
                            <div class="col-md-2">
                                <a href="{{ route('paymethods.index') }}" type="button"
                                   class="btn btn-primary btn-sm btn-block">К списку методов</a>
                            </div>
                            <div class="col-md-2">
                                <button type="submit"  class="btn btn-success btn-sm btn-block">Обновить описание метода</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection