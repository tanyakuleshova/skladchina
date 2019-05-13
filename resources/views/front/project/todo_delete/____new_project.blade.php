@extends('layouts.app')
@section('style')
    <link href="{{asset('administrator/css/plugins/summernote/summernote.css')}}" rel="stylesheet">
    <link href="{{asset('administrator/css/plugins/summernote/summernote-bs3.css')}}" rel="stylesheet">
@endsection
@section('content')
    <div class="wrap">
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-md-12 create_wrap">
                        <h2 class="caption"><span class="greeny">створення</span> проекту</h2>
                    </div>
                </div>
            </div>
        </section>
        @if(Session::has('success_message'))
            <div class="container">
                <span class="alert-success">{{Session::get('success_message')}}</span>
            </div>
        @endif
        @if(Session::has('warning_message'))
            <div class="container">
                <span class="alert-warning">{{Session::get('warning_message')}}</span>
            </div>
        @endif
        <section class="create_tabs">
            <div class="wide-border">
                <div class="container">
                    <div class="row">
                        <!-- <div class="col-md-12"> -->
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs nav-justified" role="tablist">
                            <li role="presentation" class="active"><a href="#tab1" aria-controls="home" role="tab"
                                                                      data-toggle="tab" title="1">Основне</a></li>
                            <li role="presentation" style="pointer-events: none;"><a style="color: rgba(177, 175, 175, 0.94);" href="#tab2" aria-controls="inform"
                                                                                     role="tab" data-toggle="tab"
                                                                                     title="2">Інформація</a></li>
                            <li role="presentation" style="pointer-events: none;"><a style="color: rgba(177, 175, 175, 0.94);" href="#tab3"
                                                                                     aria-controls="presents" role="tab"
                                                                                     data-toggle="tab" title="3">Винагороди</a>
                            </li>
                            <li role="presentation" style="pointer-events: none;"><a style="color: rgba(177, 175, 175, 0.94);" href="#tab4" aria-controls="about"
                                                                                     role="tab" data-toggle="tab"
                                                                                     title="4">Про себе</a></li>
                            <li role="presentation" style="pointer-events: none;"><a style="color: rgba(177, 175, 175, 0.94);" href="#tab5" aria-controls="score"
                                                                                     role="tab" data-toggle="tab"
                                                                                     title="5">Рахунок</a></li>
                            <li role="presentation" style="pointer-events: none;"><a style="color: rgba(177, 175, 175, 0.94);" href="#tab6" aria-controls="modern"
                                                                                     role="tab" data-toggle="tab"
                                                                                     title="6">На модерацію</a></li>
                        </ul>
                    </div>
                    <!-- </div>	 -->
                </div>
            </div>
            <div class="container">
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="tab1">
                        <div class="row">
                            <div class="col-md-8 create_project">
                                <form action="{{route('first_step_add_project')}}" method="POST"
                                      enctype="multipart/form-data">
                                    {{csrf_field()}}
                                    <label>Назва проекту</label>
                                    @if ($errors->has('project_name'))
                                        <div class="alert alert-danger">
                                            <strong>{{ $errors->first('project_name') }}</strong>
                                        </div>
                                    @endif
                                    <input type="text" name="project_name" placeholder="0/60" required>
                                    <label>Обкладинка</label>
                                    <div class="img_profile">
                                        <input type="file" name="poster_link" multiple accept="image/jpeg,image/png">
                                        <p>JPEG, PNG, BMP.</p>
                                        <p>Максимальний розмір файлу 10 МБ.</p>
                                        <p>Мінімальна дозвіл 600 × 360 пікселів</p>
                                    </div>
                                    <label>Короткий опис</label>
                                    @if ($errors->has('short_descr'))
                                        <div class="alert alert-danger">
                                            <strong>{{ $errors->first('short_descr') }}</strong>
                                        </div>
                                    @endif
                                    <textarea rows="4" name="short_descr" maxlength="100" placeholder="0/100"
                                              required></textarea>
                                    <label>Категорія</label>
                                    @if ($errors->has('category_id'))
                                        <div class="alert alert-danger">
                                            <strong>{{ $errors->first('category_id') }}</strong>
                                        </div>
                                    @endif
                                    <select name="category_id" required>
                                        <option>Виберіть ктегорію проекту</option>
                                        @foreach($categories_project as $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                    <label>Місто реалізації</label>
                                    @if ($errors->has('location'))
                                        <div class="alert alert-danger">
                                            <strong>{{ $errors->first('location') }}</strong>
                                        </div>
                                    @endif
                                    <input type="text" name="location" required>
                                    <select name="location" id="">
                                        <option> Выберите город</option>
                                        <option value="Київ">Київ</option>
                                        <option value="Харків">Харків</option>
                                        <option value="Дніпро">Дніпро</option>
                                        <option value="Одеса">Одеса</option>
                                        <option value="Запоріжжя">Запоріжжя</option>
                                        <option value="Львів">Львів</option>
                                        <option value="Миколаїв">Миколаїв</option>
                                        <option value="Кривий Ріг">Кривий Ріг</option>
                                        <option value="Маріуполь">Маріуполь</option>
                                        <option value="Суми">Суми</option>
                                        <option value="Черкаси">Черкаси</option>
                                    </select>
                                    <label>Тип проекту</label>
                                    @if ($errors->has('type_status_id'))
                                        <div class="alert alert-danger">
                                            <strong>{{ $errors->first('type_status_id') }}</strong>
                                        </div>
                                    @endif
                                    <div class="radiobutton">
                                        @foreach($type_status_projects as $status_project)
                                            <p><input type="radio" name="type_status_id"
                                                      value="{{$status_project->id}}">{{$status_project->name}}</p>
                                        @endforeach
                                    </div>
                                    <p class="create_project_description">Опис проекту має бути чітким і захоплюючим.
                                        Розкажіть всім, чому ви робите цей проект, як виникла ідея і навіщо вам потрібна
                                        підтримка. Переконайте людей в тому, що тільки з їх допомогою проект може стати
                                        успішним. </p>
                                    <label>Тривалість проекту</label>
                                    @if ($errors->has('date_end_project'))
                                        <div class="alert alert-danger">
                                            <strong>{{ $errors->first('date_end_project') }}</strong>
                                        </div>
                                    @endif
                                    <input type="date" name="date_end_project" id="date"
                                           placeholder="Закінчення по даті та часу">
                                    <label>Потрібна сума</label>
                                    @if ($errors->has('need_sum'))
                                        <div class="alert alert-danger">
                                            <strong>{{ $errors->first('need_sum') }}</strong>
                                        </div>
                                    @endif
                                    <input type="number" name="need_sum" placeholder="грн." min="0" required>
                                    <div class="buttons_project">
                                        <a href="{{redirect()->back()->getTargetUrl()}}" class="project_back"><img
                                                    src="{{asset('images/front/create_back_btn.png')}}" height="11"
                                                    width="7" alt="">Назад
                                        </a>
                                        <button class="project_save">зберегти</button>
                                    </div>
                                </form>

                                @if(Session::has('create_project_id'))
                                <a href="{{route('second_form_add_project',Session::get('create_project_id'))}}" class="project_next">вперед<img
                                src="{{asset('images/front/create_next_btn.png')}}" height="11"
                                width="7" alt=""></a>
                                @endif
                            </div>

                            <div class="col-md-4 create_view">
                                <img class="create_view_img" src="{{asset('images/front/view.png')}}" height="10"
                                     width="16" alt="">
                                <a href="#">Попередній перегляд</a>
                                <div class="col-md-12 product_wrap create_product_wrap">
                                    <img src="product1.jpg" width="360" height="200">
                                    <div class="product_wrap_info">
                                        <h3>Купон на измену или как пережить кризис.</h3>
                                        <p>Ироничная комедия о том, как жена разрешает мужу изменить и помогает с
                                            поиском подходящей девушки.</p>
                                        <span>Автор:<a
                                                    href=""> {{Auth::user()->name.' '.Auth::user()->last_name}}</a></span>
                                        <div class="media">
                                            <img src="{{asset('images/front/media.png')}}" width="15" height="15">
                                            <p>Відео; аудіо</p>
                                        </div>
                                        <div class="place">
                                            <img src="{{asset('images/front/place.png')}}" width="12" height="15">
                                            <p>Одеса</p>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-success" role="progressbar"
                                                 aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"
                                                 style="width: 10%">
                                                <span class="sr-only">10% Complete (success)</span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 product_statistics">
                                                <h4>10%</h4>
                                                <p>прогрес</p>
                                            </div>
                                            <div class="col-md-4 product_statistics product_statistics_center">
                                                <h4>2398054 грн</h4>
                                                <p>зібрав</p>
                                            </div>
                                            <div class="col-md-4 product_statistics">
                                                <h4>16 годин</h4>
                                                <p>залишилось</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('script')
    <script src="{{asset('administrator/js/plugins/summernote/summernote.min.js')}}"></script>
    <script>
        $(document).ready(function () {

            $('.summernote').summernote();

        });
    </script>
@endsection