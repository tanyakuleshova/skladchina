@extends('admin.layouts.admin-app')
@section('admin_style')
    <link href="{{asset('administrator/css/plugins/summernote/summernote.css')}}" rel="stylesheet">
    <link href="{{asset('administrator/css/plugins/summernote/summernote-bs3.css')}}" rel="stylesheet">
@endsection
@section('admin_content')
    <div class="wrapper wrapper-content  animated fadeInDown article details_project">
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="text-center article-title">
                            @if($project->mod_status == 1)
                                <div class="alert alert-danger">На модерации</div>
                            @endif
                            <h1>Форма редактирования проекта пользователя</h1>
                        </div>
                        <!-- Форма редактирования проекта -->
                        <form action="{{route('update_project_one',$project->id)}}" method="post"
                              enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label class="control-label" for="title">Название</label>
                                <input class="form-control" type="text" name="title" value="{{$project->name}}">
                            </div>
                            <div class="form-group">
                                @if($project->poster_link)
                                    <img class="img-circle" src="{{asset($project->poster_link)}}"
                                         alt="{{$project->name}}">
                                    <a class="btn btn-success" href="{{route('delete_poster_link',$project->id)}}">Удалить
                                        постер</a>
                                @else
                                    <label class="control-label" for="poster_link"></label>
                                    <input class="form-control" type="file" name="poster_link">
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="category_id" class="control-label">Категорія</label>
                                <select class="form-control" name="category_id">
                                    <option disabled selected>Виберіть категорію</option>
                                    @foreach($categories_project as $category)
                                        <option value="{{$category->id}}"
                                                @if($category->id == $project->category_id) selected @endif>{{$category->cld?$$category->cld->name:'---'}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="type_status_id" class="control-label">Тип проекту</label>
                                @foreach($type_status_projects as $status_project)
                                    <p><input type="radio" class="iCheck-helper" name="type_status_id"
                                              value="{{$status_project->id}}"
                                              @if($status_project->id == $project->project_status_id) checked @endif>{{$status_project->name}}
                                    </p>
                                @endforeach
                            </div>
                            @if($project->status and $project->status->name != "Безстроковий")
                                <div class="form-group">
                                    <label for="date_finish" class="control-label">Дата окончания :</label>
                                    <input type="date" name="date_finish" class="form-control"
                                           value="{{$project->date_finish}}">
                                </div>
                            @endif
                            <div class="form-group">
                                <label for="city_id" class="control-label">Расположение
                                    :</label><span>{{$project->location}}</span>
                                <select name="city_id">
                                    <option value="">&nbsp;</option>
                                    @foreach($cities  as $c)
                                    <option value="{{$c->id}}" 
                                            @if($c->id == $project->city_id) selected @endif>{{$c->cld?$c->cld->name:'---'}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="need_sum" class="control-label">Нужная сумма:</label>
                                <input class="form-control" type="number" min="0" name="need_sum"
                                       value="{{$project->need_sum}}">
                            </div>
                            <div class="form-group">
                                <label for="current_sum" class="control-label">Собранная сумма:</label>
                                <input class="form-control" type="number" name="current_sum" min="0"
                                       value="{{$project->current_sum}}">
                            </div>
                            <div class="form-group">
                                <label for="short_desc" class="control-label">Краткое описание </label>
                                <input class="form-control" type="text" name="short_desc"
                                       value="{{$project->short_desc}}">
                            </div>
                            <div class="form-group">
                                <label for="description" class="control-label">Описание</label>
                                <textarea name="description" class="summernote">
                                    {{$project->description}}
                                </textarea>
                            </div>
                            <button type="submit" class="btn btn-primary btn-rounded btn-block">Сохранить данные
                            </button>
                        </form>
                        <!-- ///////////////////////////// -->

                        @if($project->project_giftt_type == 1)
                            <div class="row">
                                <div class="col-lg-10 col-lg-offset-1">
                                    <hr>
                                    <h4 class="text-center  ">
                                        Подарки проекта {{$project->name}}
                                    </h4>
                                    <div class="slick_demo_2">
                                        @foreach($project->projectGifts as $gift)
                                            <div>
                                                <div class="ibox-content">
                                                    <img src="{{asset($gift->image_link)}}" width="250" height="250">
                                                    <p>
                                                        {!! $gift->description !!}
                                                    </p>
                                                    <div class="col-sm-3">
                                                        <div class="font-bold">Лимит</div>
                                                        {{$gift->limit}}
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="font-bold">Стоимость</div>
                                                        {{$gift->need_sum}} грн
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="font-bold">Способ доставки</div>
                                                        {{$gift->delivery_method}}
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="font-bold">Дата доставки</div>
                                                        {{$gift->delivery_date}}
                                                    </div>
                                                    <div class="text-center">
                                                        <a data-toggle="modal" class="btn btn-primary"
                                                           href="{{'#modalGift'.$gift->id}}">Редактировать</a>
                                                    </div>
                                                    <div id="{{'modalGift'.$gift->id}}" class="modal fade"
                                                         aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <h3 class="m-t-none m-b">Форма редактирования
                                                                            подарка</h3>
                                                                        <div class="col-sm-6 b-r">
                                                                            @if($gift->image_link)
                                                                                <img src="{{asset($gift->image_link)}}"
                                                                                     width="250" height="250">
                                                                                <a href="{{route('delete_image',$gift->id)}}"
                                                                                   class="btn btn-info">Удалить</a>
                                                                            @else
                                                                                <form action="{{route('upload_img_gift',$gift->id)}}"
                                                                                      method="POST"
                                                                                      enctype="multipart/form-data">
                                                                                    <input type="file"
                                                                                           name="image_link">
                                                                                    {{csrf_field()}}
                                                                                    <button type="submit"
                                                                                            class="btn btn-success">
                                                                                        Сохранить
                                                                                    </button>
                                                                                </form>
                                                                            @endif
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <form role="form" method="post"
                                                                                  action="{{route('edit_gift_project',$gift->id)}}">
                                                                                {{csrf_field()}}
                                                                                <div class="form-group">
                                                                                    <label>Цена</label>
                                                                                    <input type="number" name="need_sum"
                                                                                           value="{{$gift->need_sum}}"
                                                                                           class="form-control">
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label>Лимит</label>
                                                                                    <input type="number" name="limit"
                                                                                           value="{{$gift->limit}}"
                                                                                           class="form-control">
                                                                                </div>
                                                                                <div>
                                                                                    <label for="">Способ доставки
                                                                                        : {{$gift->delivery_method}}</label>
                                                                                    <select class="form-control"
                                                                                            name="delivery_method">
                                                                                        <option disabled selected>
                                                                                            Выберите способ доставки
                                                                                        </option>
                                                                                        <option value="Физический">
                                                                                            Физический
                                                                                        </option>
                                                                                        <option value="Электронный">
                                                                                            Электронный
                                                                                        </option>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label>Дата доставки</label>
                                                                                    <input type="date"
                                                                                           name="delivery_date"
                                                                                           value="{{$gift->delivery_date}}"
                                                                                           class="form-control">
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label>Описание</label>
                                                                                    <textarea class="form-control"
                                                                                              name="description">{{ $gift->description }}</textarea>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label>Вопрос пользователю</label>
                                                                                    <input type="text"
                                                                                           name="question_user"
                                                                                           value="{{$gift->question_user}}"
                                                                                           class="form-control">
                                                                                </div>
                                                                                <div>
                                                                                    <button class="btn btn-sm btn-primary pull-right m-t-n-xs"
                                                                                            type="submit"><strong>Сохранить</strong>
                                                                                    </button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-lg-12">
                                <h2>Сканы :</h2>
                                @if($project->requisites)
                                    @if($project->requisites->galleries)
                                        @foreach($project->requisites->galleries as $gallery)
                                            <img width="500" height="500" src="{{asset($gallery->link_scan)}}"></a>
                                            <a href="{{route('delete_requisities_image',$gallery->id)}}"
                                               class="btn btn-warning btn-circle btn-lg"><i class="fa fa-times"></i></a>
                                        @endforeach
                                    @endif
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 details_project_aboutProject">
                                <hr>
                                <h1 class="text-center">Реквизиты :</h1>
                                @if($project->requisites)
                                    @if($project->requisites->type_proj == 'individual')
                                        <h3 class="text-center">Юридична особа</h3>
                                        <form method="post"
                                              action="{{route('edit_individual_requisites_pr',$project->requisites->id)}}">
                                            {{csrf_field()}}
                                            <div class="form-group">
                                                <label for="position" class="control-label">Посада: </label>
                                                <input class="form-control" type="text"
                                                       value="{{$project->requisites->position}}" name="position">
                                            </div>
                                            <div class="form-group">
                                                <label for="FIO" class="control-label">ПІБ: </label>
                                                <input class="form-control" type="text"
                                                       value="{{$project->requisites->FIO}}" name="FIO">
                                            </div>
                                            <div class="form-group">
                                                <label for="name_organ" class="control-label">Повна назва
                                                    організації: </label>
                                                <input class="form-control" type="text"
                                                       value="{{$project->requisites->name_organ}}" name="name_organ">
                                            </div>
                                            <div class="form-group">
                                                <label for="country_register" class="control-label">Країна
                                                    реєстрації: </label>
                                                <input class="form-control" type="text"
                                                       value="{{$project->requisites->country_register}}"
                                                       name="country_register">
                                            </div>
                                            <div class="form-group">
                                                <label for="city" class="control-label">Місто: </label>
                                                <input class="form-control" type="text"
                                                       value="{{$project->requisites->city}}" name="city">
                                            </div>
                                            <div class="form-group">
                                                <label for="phone" class="control-label">Телефон: </label>
                                                <input class="form-control" type="text"
                                                       value="{{$project->requisites->phone}}" name="phone">
                                            </div>
                                            <div class="form-group">
                                                <label for="inn_or_rdpo" class="control-label">Код ЄДРПОУ: </label>
                                                <input class="form-control" type="text"
                                                       value="{{$project->requisites->inn_or_rdpo}}" name="inn_or_rdpo">
                                            </div>
                                            <div class="form-group">
                                                <label for="legal_address" class="control-label">Юридична
                                                    адреса: </label>
                                                <input class="form-control" type="text"
                                                       value="{{$project->requisites->legal_address}}"
                                                       name="legal_address">
                                            </div>
                                            <div class="form-group">
                                                <label for="physical_address" class="control-label">Фактична
                                                    адреса: </label>
                                                <input class="form-control" type="text"
                                                       value="{{$project->requisites->physical_address}}"
                                                       name="physical_address">
                                            </div>
                                            <div class="form-group">
                                                <label for="code_bank" class="control-label">Код банку: </label>
                                                <input class="form-control" type="text"
                                                       value="{{$project->requisites->code_bank}}" name="code_bank">
                                            </div>
                                            <div class="form-group">
                                                <label for="сhecking_account" class="control-label">Розрахунковий
                                                    рахунок: </label>
                                                <input class="form-control" type="text"
                                                       value="{{$project->requisites->сhecking_account}}"
                                                       name="сhecking_account">
                                            </div>
                                            <div class="form-group">
                                                <label for="other" class="control-label">Інше: </label>
                                                <textarea name="other"
                                                          class="summernote">{{$project->requisites->other}}</textarea>
                                            </div>
                                            <button type="submit" class="btn btn-primary btn-rounded btn-block">
                                                Сохранить реквизиты
                                            </button>
                                        </form>
                                    @elseif($project->requisites->type_proj == 'FOP')
                                        <h3 class="text-center">Фізична особа</h3>
                                        <form method="post"
                                              action="{{route('edit_fop_requisites_pr',$project->requisites->id)}}">
                                            {{csrf_field()}}
                                            <div class="form-group">
                                                <label for="FIO" class="control-label">ПІБ: </label>
                                                <input name="FIO" type="text" class="form-control"
                                                       value="{{$project->requisites->FIO}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="date_birth" class="control-label">Дата народження: </label>
                                                <input name="date_birth" type="text" class="form-control"
                                                       value="{{$project->requisites->date_birth}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="country_register" class="control-label">Країна
                                                    реєстрації: </label>
                                                <input name="country_register" type="text" class="form-control"
                                                       value="{{$project->requisites->country_register}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="city" class="control-label">Місто: </label>
                                                <input name="city" type="text" class="form-control"
                                                       value="{{$project->requisites->city}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="phone" class="control-label">Телефон: </label>
                                                <input name="phone" type="text" class="form-control"
                                                       value="{{$project->requisites->phone}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="inn_or_rdpo" class="control-label">ІНН: </label>
                                                <input name="inn_or_rdpo" type="text" class="form-control"
                                                       value="{{$project->requisites->inn_or_rdpo}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="issued_by_passport" class="control-label">Ким виданий
                                                    : </label>
                                                <input name="issued_by_passport" type="text" class="form-control"
                                                       value="{{$project->requisites->issued_by_passport}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="date_issued" class="control-label">Коли виданий: </label>
                                                <input name="date_issued" type="text" class="form-control"
                                                       value="{{$project->requisites->date_issued}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="code_bank" class="control-label">Код банку: </label>
                                                <input name="code_bank" type="text" class="form-control"
                                                       value="{{$project->requisites->code_bank}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="сhecking_account" class="control-label">Розрахунковий
                                                    рахунок: </label>
                                                <input name="сhecking_account" type="text" class="form-control"
                                                       value="{{$project->requisites->сhecking_account}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="other" class="control-label">Інше: </label>
                                                <textarea name="other"
                                                          class="summernote">{{$project->requisites->other}}</textarea>
                                            </div>
                                            <button type="submit" class="btn btn-primary btn-rounded btn-block">
                                                Сохранить реквизиты
                                            </button>
                                        </form>
                                    @else
                                        <h3 class="text-center">Підприємець</h3>
                                        <form method="post"
                                              action="{{route('edit_entity_requisites_pr',$project->requisites->id)}}">
                                            {{csrf_field()}}
                                            <div class="form-group">
                                                <label for="FIO" class="control-label">Найменування / ПІБ: </label>
                                                <input name="FIO" type="text" class="form-control"
                                                       value="{{$project->requisites->FIO}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="country_register" class="control-label">Країна
                                                    реєстрації: </label>
                                                <input class="form-control" type="text"
                                                       value="{{$project->requisites->country_register}}"
                                                       name="country_register">
                                            </div>
                                            <div class="form-group">
                                                <label for="city" class="control-label">Місто: </label>
                                                <input name="city" type="text" class="form-control"
                                                       value="{{$project->requisites->city}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="phone" class="control-label">Телефон: </label>
                                                <input name="phone" type="text" class="form-control"
                                                       value="{{$project->requisites->phone}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="inn_or_rdpo" class="control-label">ІНН: </label>
                                                <input name="inn_or_rdpo" type="text" class="form-control"
                                                       value="{{$project->requisites->inn_or_rdpo}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="legal_address" class="control-label">Юридична
                                                    адреса: </label>
                                                <input name="legal_address" type="text" class="form-control"
                                                       value="{{$project->requisites->legal_address}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="physical_address" class="control-label">Фактична
                                                    адреса: </label>
                                                <input name="physical_address" type="text" class="form-control"
                                                       value="{{$project->requisites->physical_address}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="code_bank" class="control-label">Код банку: </label>
                                                <input name="code_bank" type="text" class="form-control"
                                                       value="{{$project->requisites->code_bank}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="сhecking_account" class="control-label">Розрахунковий
                                                    рахунок: </label>
                                                <input name="сhecking_account" type="text" class="form-control"
                                                       value="{{$project->requisites->сhecking_account}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="other" class="control-label">Інше: </label>
                                                <textarea name="other"
                                                          class="summernote">{{$project->requisites->other}}</textarea>
                                            </div>
                                            <button type="submit" class="btn btn-primary btn-rounded btn-block">
                                                Сохранить реквизиты
                                            </button>
                                        </form>
                                    @endif
                                @endif
                                <a class="btn btn-info"
                                   href="{{route('admin_project.index')}}">Назад</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .slick_demo_2 .ibox-content {
            margin: 0 10px;
        }
    </style>
@endsection
@section('admin_script')
    <script src="{{asset('administrator/js/plugins/summernote/summernote.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('.summernote').summernote();
        });
    </script>
@endsection