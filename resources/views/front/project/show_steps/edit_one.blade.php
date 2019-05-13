@extends('layouts.app')
@section('title','Основное')
@section('style')
<link href="{{asset('administrator/css/plugins/summernote/summernote.css')}}" rel="stylesheet">
<link href="{{asset('administrator/css/plugins/summernote/summernote-bs3.css')}}" rel="stylesheet">
@endsection
@section('content')
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                {!!trans('createproject.headerzag')!!}
            </div>
        </div>
    </div>
</section>

<section class="create_tabs">
    <div class="wide-border">
        @include('front.project.show_steps.navigation_steps',['nstep'=>1,'project'=>$project])
    </div>

    <div class="container">
        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="tab1">
                <div class="row">
                    <div class="col-md-8">
                        <div class="create_project">
                            <form action="{{route('update_project',['id'=>$project->id,'step'=>1])}}" method="POST" enctype="multipart/form-data">
                                {{csrf_field()}}
                                {{ method_field('PUT') }}
                                <label class="top_reset">{{trans('createproject.nameproj')}}</label>
                                <div class="input-group project_name">
                                    <input type="text"
                                           name="project_name" 
                                           class="js_counter_symbol"
                                           placeholder="Введите название проекта" 
                                           maxlength="70" 
                                           value="{{$project->name}}">
                                    <div class="input-group-addon js_counter_symbol_counter"></div>
                                </div>
                                <p class="descriptioncreateproject">{{trans('createproject.descriptionname')}}</p>
                                
                                @if($project->SEO)
                                    <p class="descriptioncreateproject"><i>SEO URL</i>: /{{$project->SEO}}</p>
                                @endif
                                
                                <label>{{trans('createproject.poster')}}</label>
                                @if($project->poster_link)
                                <img class="create_view_img img-responsive" src="{{asset($project->poster)}}" alt="{{$project->name}}">
                                @endif
                                <div class="media_profile">
                                    <a href="#"><img src="{{asset('images/front/add_photo.png')}}" alt=""></a>
                                    <div class="media_profile_info">
                                        <input type="file" name="poster_link" multiple accept="image/jpeg,image/png" placeholder="Завантажити зображення">
                                        {!!trans('createproject.paramposter')!!}
                                    </div>
                                </div>

                                <label>{{trans('createproject.shotdesc')}}</label>
                                <div class="shortdesc">
                                    <textarea rows="4" 
                                              name="short_descr" 
                                              maxlength="140" 
                                              class="js_counter_symbol"
                                              placeholder="{{trans('createproject.shotdesc')}}">{{$project->short_desc}}</textarea>
                                    <div class="input-group-addon js_counter_symbol_counter"></div>
                                </div>
                                <p class="descriptioncreateproject">{{trans('createproject.shortdescriptionproj')}}</p>

                                <label>{{trans('createproject.category')}}</label>
                                <select name="category_id" class="pr_selector">
                                    <option value="">{{trans('createproject.selectcategory')}}</option>
                                    @foreach($categories_project as $category)
                                    <option value="{{$category->id}}" @if($category->id == $project->category_id) selected @endif>{{$category->cld?$category->cld->name:''}}</option>
                                    @endforeach
                                </select>
                                <p class="descriptioncreateproject">{{trans('createproject.categorydescriptionproj')}}</p>

                                <label>{{trans('createproject.townproj')}}</label>
                                <select name="city_id" class="pr_selector">
                                    <option value="">&nbsp;</option>
                                    @foreach($city as $c)
                                    <option value="{{$c->id}}" @if($c->id == $project->city_id) selected @endif>{{$c->cld?$c->cld->name:'---'}}</option>
                                    @endforeach
                                </select>
                                <p class="descriptioncreateproject">{{trans('createproject.towndescriptionproj')}}</p>

                                <label>{{trans('createproject.typeproject')}}</label>
                                <div class="radiobutton radiobutton_type_project">
                                    @foreach($type_project as $type)
                                    <p><input type="radio" 
                                      name="type_status_id" 
                                      class="js_project_type"
                                      value="{{$type->id}}" 
                                      {{ ($type->id == $project->type_id)?'checked':''}} />{{$type->name}}</p>
                                      @endforeach
                                </div>
                                <div class="description">
                                    @foreach($type_project as $type)
                                    <div class="js_description_type hidden" data-type_id="{{$type->id}}">
                                       {!! $type->shortDescription !!}
                                   </div>
                                   @endforeach
                                </div>

                                <div class="js_description_type hidden"  data-type_id="1">
                                    <label>{{trans('createproject.longproj')}}</label>
                                    <input class="longproj" type="number" name="duration" id="duration" min="1" max="100" value="{{$project->duration}}">
                                    <p class="descriptioncreateproject_longproj">{!!trans('createproject.longdescriptionproj')!!}</p>
                                </div>
                                <div class="clearfix"></div>
                                <div class="">
                                    <label>{{trans('createproject.needsumm')}}</label>
                                    <input class="longproj" type="number" name="need_sum" placeholder="грн." min="0" value="{{$project->need_sum}}">
                                    <p class="descriptioncreateproject_longproj">{!!trans('createproject.summdescriptionproj')!!}</p>
                                </div>
                                <div class="buttons_project">
                                    <button class="btn project_save">{{trans('createproject.saveprojectdet')}}<!-- <i class="fa fa-chevron-right"></i> --></button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-4 create_view">
                        <div class="previous_view">
                            <img class="create_view_img" src="{{asset('images/front/view.png')}}" height="10" width="16" alt="">
                            <!--a href="#">{{trans('createproject.previewproj')}}</a-->
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="product_wrap create_product_wrap">
                                    @include('front.project.blocks.show_small_project_nowrap',['project'=>$project])
                                </div>
                            </div>
                        </div>
                        
                        <div class="description project-type-description">
                            @foreach($type_project as $type)
                            <div class="js_description_type hidden" data-type_id="{{$type->id}}">
                                {!! $type->description !!}
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if($first_start)
        <!-- Modal -->
        <div class="modal fade" id="myModal_first_start" tabindex="-1" role="dialog" aria-labelledby="myModalLabel_first_start">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel_first_start">
                    Поздравляем, {{ $project->author->fullName }}</h4>
                <h5>вы осуществили первый шаг к реализации своей идеи.</h5>
              </div>
              <div class="modal-body">
                <p>Теперь заполните все поля данного конструктора проектов, по возможности пользуясь подсказками.Будьте внимательны, не упускайте важных деталей, не забывайте сохранять изменения и, конечно-же, хорошее настроение.</p>
                <p>Перед наполнением проекта информацией рекомендуем ознакомиться с нашим <a href="#">Руководством по краудфандингу.</a></p>
                <p>Проект автоматически добавлен в список ваших проектов. Получить к нему доступ и продолжить работу вы можете в разделе «Мои проекты» по адресу <a href="https://dreamstarter.com.ua/myprojects">https://dreamstarter.com.ua/myprojects</a></p>
                <p>По любым вопросам обращайтесь на support@dreamstarter.com.ua или к вашему личному менеджеру (указан на последней странице конструктора).</p>
                <h6>Действуйте!</h6>
              </div>
              <div class="modal-footer">
                <button class="btn" data-dismiss="modal">ПОЕХАЛИ!</button>
              </div>
            </div>
          </div>
        </div>
        <script>
        $(document).ready(function () {
            $('#myModal_first_start').modal('show');
        });
        </script>
        <!-- End Modal -->
    @endif
    
</section>


@endsection

@section('script')
<script>
$(document).ready(function () {

    $(document).on('click','.js_project_type', function(){
        var valueTR = this.value;
        $('.js_description_type').
        addClass('hidden').
        each(function(){
            if ($(this).data('type_id') == valueTR){
                $(this).removeClass('hidden');
            }
        });
    });

    var all_types_project = $('input.js_project_type');
    if (all_types_project.filter(':checked').length === 0) {
        all_types_project.first().click();
    } else {
        all_types_project.filter(':checked').first().click();
    }



//
});
</script>


<script>
    $(document).ready(function(){

        $(".create_project [name=project_name], .create_project [name=short_descr]").on('focus blur', function()
        {
            var cl = "border-count";
            var el = $(this);

            if (el.hasClass(cl)) 
            {
                el.removeClass(cl);
                el.next().removeClass(cl);
            } 
            else {
                el.addClass(cl);
                el.next().addClass(cl);
            }
        });
    });
</script>

@endsection
