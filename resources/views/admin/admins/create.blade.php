@extends('admin.layouts.admin-app')

@section('admin_content')
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5> Форма создания Администратора </h5>
        </div>
        <div>
            <div class="ibox-content profile-content">
                <form action="{{ route('admins.store') }}" enctype="multipart/form-data" method="POST">
                    {{csrf_field()}}

                    <div class="form-group">
                        <label for="image_avatar" class="control-label">Аватар</label>
                        <input type="file" name="image_avatar" accept="image/jpeg,image/png">
                    </div>
                    
                    
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <input id="name" placeholder="{{trans('auth.name')}}" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                    </div>
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <input id="email" placeholder="Email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                    </div>
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <input id="password" placeholder="{{trans('auth.password')}}"  type="password" class="form-control" name="password" required>
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                    </div>
                    <input id="password-confirm" placeholder="{{trans('auth.password_confirmation')}}"  type="password" class="form-control" name="password_confirmation"  required="required">

                    
                    
                    <hr>
                    <div class="user-button">
                        <div class="row">
                            <div class="col-md-2">
                                <a href="{{ route('admins.index') }}" type="button"
                                   class="btn btn-primary btn-sm btn-block">Назад</a>
                            </div>
                            <div class="col-md-2">
                                <button type="submit"  class="btn btn-success btn-sm btn-block">Создать АДМИНА</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection