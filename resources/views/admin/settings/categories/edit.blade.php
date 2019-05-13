@extends('admin.layouts.admin-app')
@section('admin_content')
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5> Форма редактирования категории 
            @if($category->lang->isEmpty())
                {{ ' --old-> "' . $category->name . '" <-old-- ' }}
            @else
                {{ ' "' . $category->descript->name . '"'}}
            @endif
            </h5>
        </div>
        <div>
            <div class="ibox-content profile-content">
                <form action="{{ route('catgories_project.update',$category->id) }}" method="POST">
                    <input type="hidden" name="_method" value="PUT">
                    {{csrf_field()}}

                    
                    @foreach(LaravelLocalization::getSupportedLocales() as $key=>$lang)
                        <?php
                            $x = $category->lang->where('language', $key)->first(); //работаем с коллекцией, без запросов в базу
                            $cd = $x?$x->name:'';                                  //если добавился язык и описания нет
                            $td = $x?$x->description:'';
                        ?>

                        {!! !$loop->first?'<hr><hr>':'' !!}
                        <div class="form-group">
                            <label for="category[{{$key}}]" class="control-label">{{ trans('createproject.category').' '.$lang['native'] }}</label>
                            <input type="text" name="category[{{$key}}]" value="{{ old('category.'.$key)?old('category.'.$key):$cd }}" class="form-control">
                        </div>
                        
                        <div class="form-group">
                            <label for="description[{{$key}}]" class="control-label">{{ trans('createproject.presentreview').' '.$lang['native'] }}</label>
                            <textarea name="description[{{$key}}]" class="form-control">{{ old('description.'.$key)?old('description.'.$key):$td }}</textarea>
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