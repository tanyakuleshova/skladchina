@extends('admin.layouts.admin-app')
@section('admin_content')
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5> Форма создания категории для проектов</h5>
        </div>
        <div>
            <div class="ibox-content profile-content">
                <form action="{{route('catgories_project.store')}}" method="POST">
                    {{csrf_field()}}
                    @foreach(LaravelLocalization::getSupportedLocales() as $key=>$lang)
                    {!! !$loop->first?'<hr><hr>':'' !!}
                    <div class="form-group">
                        <label for="category[{{$key}}]" class="control-label">{{ trans('createproject.category').' '.$lang['native'] }}</label>
                        <input type="text" name="category[{{$key}}]" value="{{ old('category.'.$key) }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="description[{{$key}}]" class="control-label">{{ trans('createproject.presentreview').' '.$lang['native'] }}</label>
                        <textarea name="description[{{$key}}]" class="form-control">{{ old('description.'.$key) }}</textarea>
                    </div>
                    @endforeach
                   

                    <div class="user-button">
                        <div class="row">
                            <div class="col-md-2">
                                <a href="{{ route('catgories_project.index') }}" type="button"
                                   class="btn btn-primary btn-sm btn-block">К списку категорий</a>
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