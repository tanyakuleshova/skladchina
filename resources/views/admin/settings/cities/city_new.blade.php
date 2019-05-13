@extends('admin.layouts.admin-app')
@section('admin_content')
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5> Форма создания города</h5>
        </div>
        <div>
            <div class="ibox-content profile-content">
                <form action="{{route('cities.store')}}" method="POST">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="seo" class="control-label">SEO</label>
                        <input type="text" name="seo" value="{{ old('seo') }}" class="form-control">
                    </div>
                    
                    @foreach(LaravelLocalization::getSupportedLocales() as $key=>$lang)
                    <hr>
                    <div class="form-group">
                        <label for="city" class="control-label">{{ trans('createproject.town').' '.$lang['native'] }}</label>
                        <input type="text" name="city[{{$key}}]" value="{{ old('city.'.$key) }}" class="form-control">
                    </div>
                    @endforeach
                   

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