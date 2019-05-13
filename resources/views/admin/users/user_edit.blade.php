@extends('admin.layouts.admin-app')
{{--@section('admin_style')--}}
{{--<link href="{{asset('administrator/css/plugins/summernote/summernote.css')}}" rel="stylesheet">--}}
{{--<link href="{{asset('administrator/css/plugins/summernote/summernote-bs3.css')}}" rel="stylesheet">--}}
{{--@endsection--}}
@section('admin_content')
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5> Форма редактирования профиля пользователя {{$user->name}}</h5>
        </div>
        <div>
            <div class="ibox-content no-padding border-left-right">
                <img alt="image" class="img-circle circle-border m-b-md"
                     src="{{ asset( $user->avatar) }}">
            </div>
            <div class="ibox-content profile-content">
                <form action="{{route('users.update',$user->id)}}" method="POST">
                    <input type="hidden" name="_method" value="PUT">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label  class="control-label">Баланс : {{ $user->getMyBalance() }} грн.</label>
                    </div>
                    <div class="form-group">
                        <label for="name_user" class="control-label">Имя</label>
                        <input type="text" name="name_user" value="{{$user->name}}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="last_name_user" class="control-label">Фамилия</label>
                        <input type="text" name="last_name_user" value="{{$user->last_name}}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="city" class="control-label">Город</label>
                        <input type="text" name="city" value="{{$user->account->city_birth}}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="phone" class="control-label">Телефон</label>
                        <input type="text" name="phone" value="{{$user->account->contact_phone}}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="about_user" class="control-label">О себе</label>
                        <textarea name="about_user" class="form-control" id=""
                                  style="width: 100%; height: 200px">{{$user->account->about_self}}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="day_birth" class="control-label">Дата рождения</label>
                        <input type="date" name="day_birth" value="{{$user->account->day_birth}}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="user_site" class="control-label">Сайт пользователя</label>
                        <input type="text" name="user_site" value="{{$user->account->user_site}}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="social_href_facebook" class="control-label">Facebook</label>
                        <input type="text" name="social_href_facebook" value="{{$user->account->social_href_facebook}}"
                               class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="social_href_google" class="control-label">Google+</label>
                        <input type="text" name="social_href_google" value="{{$user->account->social_href_google}}"
                               class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="social_href_twitter" class="control-label">Twitter</label>
                        <input type="text" name="social_href_twitter" value="{{$user->account->social_href_twitter}}"
                               class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="social_href_youtube" class="control-label">YouTube</label>
                        <input type="text" name="social_href_youtube" value="{{$user->account->social_href_youtube}}"
                               class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="social_href_instagram" class="control-label">Instagram</label>
                        <input type="text" name="social_href_instagram"
                               value="{{$user->account->social_href_instagram}}" class="form-control">
                    </div>

                    <div class="user-button">
                        <div class="row">
                            <div class="col-md-2">
                                <a href="{{redirect()->back()->getTargetUrl()}}" type="button"
                                   class="btn btn-primary btn-sm btn-block">Назад</a>
                            </div>
                            <div class="col-md-2">
                                <button type="submit"  class="btn btn-success btn-sm btn-block">Сохранить</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
{{--@section('admin_script')--}}
{{--<script src="{{asset('administrator/js/plugins/summernote/summernote.min.js')}}"></script>--}}
{{--<script>--}}
{{--$(document).ready(function(){--}}

{{--$('.summernote').summernote();--}}

{{--});--}}
{{--</script>--}}
{{--@endsection--}}