@extends('admin.layouts.admin-app')

@section('admin_content')
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5> Форма редактирования профиля Администратора " {{ $admin->fullName }} "</h5>
        </div>
        <div>
            <div class="ibox-content no-padding border-left-right">
                <img alt="image" class="img-circle circle-border m-b-md"
                     src="{{ asset($admin->avatar) }}">
            </div>
            <div class="ibox-content profile-content">
                <form action="{{route('admins.update',$admin->id)}}" enctype="multipart/form-data" method="POST">
                    <input type="hidden" name="_method" value="PUT">
                    {{csrf_field()}}

                    <div class="form-group">
                        <label for="image_avatar" class="control-label">Сменить аватар</label>
                        <input type="file" name="image_avatar" accept="image/jpeg,image/png">
                    </div>

                    <div class="form-group ">
                        <label for="status" class="control-label">Включен/отключен</label>
                        <input type="checkbox" name="status" {{ $admin->isStatus?'checked="checked"':'' }} class="form-control">
                    </div>
                    
                    <div class="form-group ">
                        <label for="status" class="control-label">Ограничения менеджера?</label>
                        <input type="checkbox" name="manager" {{ $admin->isAdmin?'':'checked="checked"' }} class="form-control">
                    </div>
                    
                    <div class="form-group">
                        <label for="password" class="control-label">Сменить пароль ?</label>
                        <input type="password" name="password"  class="form-control" placeholder="{{trans('auth.password')}}">
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                    </div>
                    <input id="password-confirm" placeholder="{{trans('auth.password_confirmation')}}"  type="password" class="form-control" name="password_confirmation">
                    <hr>
                    <div class="form-group">
                        <label for="name_user" class="control-label">Имя</label>
                        <input type="text" name="name_user" value="{{ $admin->name }}" class="form-control">
                    </div>
                    
                    <div class="form-group">
                        <label for="last_name_user" class="control-label">Фамилия</label>
                        <input type="text" name="last_name_user" value="{{ $admin->account->last_name }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="city" class="control-label">Город</label>
                        <input type="text" name="city" value="{{ $admin->account->city_birth }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="phone" class="control-label">Телефон</label>
                        <input type="text" name="phone" value="{{ $admin->account->contact_phone }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="about_user" class="control-label">О себе</label>
                        <textarea name="about_user" class="form-control"
                                  style="width: 100%; height: 200px">{{ $admin->account->about_self }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="day_birth" class="control-label">Дата рождения</label>
                        <input type="text" name="day_birth" value="{{ $admin->account->day_birth }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="social_href_facebook" class="control-label">Facebook</label>
                        <input type="text" name="social_href_facebook" value="{{ $admin->account->social_href_facebook}}"
                               class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="social_href_google" class="control-label">Google+</label>
                        <input type="text" name="social_href_google" value="{{ $admin->account->social_href_google}}"
                               class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="social_href_twitter" class="control-label">Twitter</label>
                        <input type="text" name="social_href_twitter" value="{{ $admin->account->social_href_twitter}}"
                               class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="social_href_youtube" class="control-label">YouTube</label>
                        <input type="text" name="social_href_youtube" value="{{ $admin->account->social_href_youtube}}"
                               class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="social_href_instagram" class="control-label">Instagram</label>
                        <input type="text" name="social_href_instagram"
                               value="{{ $admin->account->social_href_instagram}}" class="form-control">
                    </div>

                    <div class="user-button">
                        <div class="row">
                            <div class="col-md-2">
                                <a href="{{ route('admins.index') }}" type="button"
                                   class="btn btn-primary btn-sm btn-block">Назад</a>
                            </div>
                            <div class="col-md-2">
                                <button type="submit"  class="btn btn-success btn-sm btn-block">Обновить</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection