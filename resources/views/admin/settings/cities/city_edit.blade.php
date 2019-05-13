@extends('admin.layouts.admin-app')
@section('admin_content')
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5> Форма редактирования города</h5>
        </div>
        <div>
            <div class="ibox-content profile-content">
                <form action="{{ route('cities.update',$city->id) }}" method="POST">
                    <input type="hidden" name="_method" value="PUT">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="seo" class="control-label">SEO</label>
                        <input type="text" name="seo" value="{{ old('seo')?old('seo'):$city->seo }}" class="form-control">
                    </div>
                    
                    @foreach(LaravelLocalization::getSupportedLocales() as $key=>$lang)
                        <?php
                            $cd = $city->lang->where('language', $key)->first(); //работаем с коллекцией, без запросов в базу
                            $cd = $cd?$cd->name:'';                              //если добавился язык и описания нет
                        ?>

                        <hr>
                        <div class="form-group">
                            <label for="city[{{$key}}]" class="control-label">{{ trans('createproject.town').' '.$lang['native'] }}</label>
                            <input type="text" name="city[{{$key}}]" value="{{ old('city.'.$key)?old('city.'.$key):$cd }}" class="form-control">
                        </div>
                    @endforeach
                   

                    <div class="user-button">
                        <div class="row">
                            <div class="col-md-2">
                                <a href="{{ route('cities.index') }}" type="button"
                                   class="btn btn-primary btn-sm btn-block">К списку городов</a>
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