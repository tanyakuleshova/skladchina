@extends('admin.layouts.admin-app')
@section('admin_style')
    <link href="{{asset('administrator/css/plugins/summernote/summernote.css')}}" rel="stylesheet">
    <link href="{{asset('administrator/css/plugins/summernote/summernote-bs3.css')}}" rel="stylesheet">
@endsection
@section('admin_content')
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5> Форма создания страницы</h5>
        </div>
        <div>
            <div class="ibox-content profile-content">
                <form action="{{route('a_s_page.store')}}" method="POST">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="slug" class="control-label">Slug SEO</label>
                        <input type="text" name="slug" value="{{ old('slug') }}" class="form-control">
                    </div>
                    
                    
                    
                    
                    
                        <div class="col-xs-12 col-md-12">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                @foreach(LaravelLocalization::getSupportedLocales() as $key=>$lang)
                                <li role="presentation" class="{{ $loop->first?'active':''}}">
                                    <a href="#my_native_{{ $lang['regional'] }}" 
                                       aria-controls="#my_native_{{ $lang['regional'] }}" 
                                       role="tab" 
                                       data-toggle="tab">{{ $lang['native'] }}</a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    
                    
                        <!-- Tab panes -->
                        <div class="tab-content">
                            @foreach(LaravelLocalization::getSupportedLocales() as $key=>$lang)

                            <div role="tabpanel" class="tab-pane {{ $loop->first?'active':''}}" id="my_native_{{ $lang['regional'] }}">
                                
                                <hr>
                                <div class="form-group">
                                    <label for="title" class="control-label">{{ 'title '.$lang['native'] }}</label>
                                    <input type="text" name="title[{{$key}}]" value="{{ old('title.'.$key) }}" class="form-control">
                                </div>
                                
                                <hr>
                                <div class="form-group">
                                    <label for="name" class="control-label">{{ 'name '.$lang['native'] }}</label>
                                    <input type="text" name="name[{{$key}}]" value="{{ old('name.'.$key) }}" class="form-control">
                                </div>
                                
                                <hr>
                                <div class="form-group">
                                    <label for="meta_description" class="control-label">{{ 'meta_description '.$lang['native'] }}</label>
                                    <input type="text" name="meta_description[{{$key}}]" value="{{ old('meta_description.'.$key) }}" class="form-control">
                                </div>
                                
                                <hr>
                                <div class="form-group">
                                    <label for="meta_keywords" class="control-label">{{ 'meta_keywords '.$lang['native'] }}</label>
                                    <input type="text" name="meta_keywords[{{$key}}]" value="{{ old('meta_keywords.'.$key) }}" class="form-control">
                                </div>

                                <hr>
                                <div class="form-group">
                                    <label for="description" class="control-label">{{ 'description '.$lang['native'] }}</label>
                                    <textarea name="description[{{$key}}]" 
                                              class="summernote form-control">{{ old('description.'.$key) }}</textarea>
                                </div>
                                
                                
                                
                                
                                
                            </div>
                            @endforeach
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
@section('admin_script')
    <script src="{{asset('administrator/js/plugins/summernote/summernote.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('.summernote').summernote();
        });
    </script>
@endsection