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
                <div class="col-md-12">
                    <h2 class="create_title"><span class="greeny">створення</span> проекту</h2>
                </div>
            </div>
        </div>
    </section>
    @if(Session::has('success_message'))
        <div class="container">
            <div class="alert alert-success">{{Session::get('success_message')}}</div>
        </div>
    @endif
    @if(Session::has('warning_message'))
        <div class="container">
            <div class="alert alert-warning">{{Session::get('warning_message')}}</div>
        </div>
    @endif
    <section class="create_tabs">
        <div class="wide-border">
            @include('front.project.show_steps.navigation_steps',['nstep'=>3,'project'=>$project])
        </div>
        <div class="container">
            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="tab3">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="create_project create_present">  
                                <form action="{{route('third_step_project',$project->id)}}" method="post"  >
                                    {{csrf_field()}}
                                    <label class="top_reset">{{trans('createproject.typeproject3')}}</label>
                                    <div class="radiobutton radiobutton_type_project">
                                        <p><input type="radio" name="type" value="1"
                                            @if($project->project_giftt_type == 1) checked @endif>
                                            {{trans('createproject.withpresent')}}
                                        </p>
                                        <p><input type="radio" name="type" value="0"
                                            @if($project->project_giftt_type == 0) checked @endif>
                                            {{trans('createproject.withoutpresent')}}
                                        </p>
                                    </div>
                                    <div class="buttons_project">
                                        <button class="btn project_save">{{trans('createproject.saveprojectdet')}}<i class="fa fa-chevron-right"></i></button>
                                    </div>
                                </form>

                                @if($project->project_giftt_type == 1)
                                    <div id="aj_gift_create"></div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="rewards">
                                @if($project->project_giftt_type == 1)
                                    @foreach($project->projectGifts as $gift)
                                        <div class='aj_gift_small' data-id='{{$gift->id}}' data-project_id='{{$project->id}}'></div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="edit_gift_modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content modal-lg">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title text-center">Редактирование награды</h4>
      </div>
      <div class="modal-body"  id="edit_gift_modal_body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@endsection
@section('script')
    <script src="{{asset('administrator/js/plugins/summernote/summernote.min.js')}}"></script>
    <script src="{{asset('js/imagepreview.js')}} "></script>
    <script>
        $('#edit_gift_modal').on('hidden.bs.modal', function (e) {
          $('#edit_gift_modal_body').empty();
        })
        
        $(document).ready(function () {

            $('.summernote').summernote();
            
            $('.aj_gift_small').each(function(){
                var el = $(this);var id = el.data('id');
                getSmileG(el,id);
            })
            

            if ($('#aj_gift_create').html() == '') {
                $.ajax({
                    type : 'GET',
                    url : '{{route("ugift.create")}}?project_id={{$project->id}}',
                }).done(function (data) {
                    if (data.errors) {
                        console.log(data.errors);
                    } else {
                        $('#aj_gift_create').html(data);
                    }
                }).fail(function () {
                    console.log('-- ошибка инициализация формы --');
                });
            }


        });

        //вызов формы редактирования подарка
        $(document).on('click', '.aj_gift_small .edit_gift_btn', function (e) {
            e.preventDefault();
            var block = $(this).parents('.aj_gift_small').first();
            var gurl = '{{route("ugift.index")}}/'+ block.data('id') + '/edit?project_id=' + block.data('project_id');
            
            $.ajax({
                type : 'GET',
                url : gurl
                }).done(function (ret) {
                    if (ret.errors !== undefined) {
                        console.log(ret.errors);
                    };
                    if (ret.forma !== undefined){
                        $('#edit_gift_modal_body').html(ret.forma);
                        $('#edit_gift_modal').modal('show');
                    }
                }).fail(function (ret) {
                    console.log('-- ошибка запроса ', gurl , ret);
                });

            });

        //редактирование подарка
        $(document).on('click', '#edit_gift_modal_body .update_present_btn', function (e) {
            e.preventDefault();
            var forma = $(this.form);
            var action = forma.attr('action');
            var method = forma.attr('method');
            var formData = new FormData(this.form);
            
            console.log(forma.data('id'),action,method);
            

            
            
                $.ajax({
                    url: action,
                    type: method,
                    data: formData,
                    cache: false,
                    processData: false,  
                    contentType: false,
                    success: function(data){
                        if (data.errors) {
                            console.log(data.errors);
                            };  
                        if(data.forma !== undefined ) {
                            $('#edit_gift_modal_body').html(data.forma);
                            };
                        if(data.success !== undefined && data.gift !== undefined) {
                            $('.aj_gift_small').filter(function(){
                                    return $(this).data('id') == forma.data('id');
                                  }).html(data.gift);
                                  
                             $('#edit_gift_modal').modal('hide');
                        }
                    }
                });
            

            });



        //удаление подарков
        $(document).on('click', '.aj_gift_small .delete_gift_btn', function (e) {
            e.preventDefault();
            var block = $(this).parents('.aj_gift_small').first();
            
            if (checkDelete(', что хотите удалить этот подарок')) {
                var gurl = '{{route("ugift.index")}}/'+ block.data('id') + '?_method=DELETE&project_id=' + block.data('project_id');
                $.ajax({
                    type : 'POST',
                    url : gurl
                }).done(function (ret) {
                    if (ret.errors) {
                        console.log(ret.errors);
                    } else if (ret === 'true'){
                        block.remove();
                    }
                }).fail(function (ret) {
                    console.log('-- ошибка запроса ', gurl , ret);
                });
            }
            });
            
            
        $(document).on('click', '#aj_gift_create .save_present_btn', function (e) {
            e.preventDefault();
            var forma = $(this.form);
            var action = forma.attr('action');
            var method = forma.attr('method');
            var formData = new FormData(this.form);

            $.ajax({
              url: action,
              type: method,
              data: formData,
              cache: false,
                processData: false,  
                contentType: false,
              success: function(data){
                if (data.errors) {
                    console.log(data.errors);
                } else if(data.gift !== undefined ) {
                     $('#aj_gift_create').html(data.forma);
                     $('.rewards').append(data.gift);
                } else {
                    $('#aj_gift_create').html(data);
                }
              }
            });
        });
        
        function ajax_gp(action, method, datak , element) {
            $.ajax({
                type : method,
                url : action,
                data : datak
            }).done(function (ret) {
                if (ret.errors) {
                    console.log(ret.errors);
                } else {
                    return ret;
                }
            }).fail(function (ret) {
                console.log('-- ошибка запроса ', action, method, datak , ret);
            });
        }
        
        function getSmileG(element, id) {
            var gurl = '{{route("ugift.index")}}/'+ id + '?small=1';
            $.ajax({
                type : 'GET',
                url : gurl,
            }).done(function (data) {
                element.html(data);
            }).fail(function () {
                console.log('-- неверный id=' + id);
            });
        }
        
        function checkDelete(text) {
            if (text === undefined) {
                text='';
            }
            return confirm('Вы уверены ' + text + ' ?');
        }
        
    </script>
@endsection