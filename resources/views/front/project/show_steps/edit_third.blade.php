@extends('layouts.app')
@section('title','Вознаграждения')
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
        @include('front.project.show_steps.navigation_steps',['nstep'=>3,'project'=>$project])
    </div>
    
    <div class="container">
        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="tab3">
                <div class="row">
                    <div class="col-md-8">
                        <div class="create_project create_present">  
                                <div id="aj_gift_create"></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="rewards">
                            <section>
                                <div class="rewards_wrap rewards_wrap_fixed">
                                    <h3>{{trans('show_project_front.anysumm')}}</h3>
                                    <p>{{trans('show_project_front.withoutpresent')}}</p>
                                    <form class="_support_project_">
                                        
                                        
                                        <input type="number" name="summa" disabled="" placeholder="{{trans('show_project_front.withoutpresentplaceholder')}}" min="1" required>
                                        <button disabled="" class="btn">{{trans('show_project_front.podderjat_fixed')}}</button>	
                                    </form>
                                </div>
                            </section>
                           
                                @foreach($project->projectGifts as $gift)
                                    <div class='aj_gift_small' data-id='{{$gift->id}}' data-project_id='{{$project->id}}'></div>
                                @endforeach
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" tabindex="-1" role="dialog" id="edit_gift_modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content modal-lg">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title text-center">{{trans('createproject.editreward')}}</h4>
      </div>
      <div class="modal-body"  id="edit_gift_modal_body">
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
            
            //console.log(forma.data('id'),action,method);
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
            swal({
                  title: "Внимание.",
                  type: 'warning',
                  text: 'Вы хотите удалить этот подарок ?',
                  showCancelButton: true,
                  confirmButtonClass: "btn-danger",
                  confirmButtonText: 'Удалить подарок',
                  cancelButtonText: 'Отмена',
                  closeOnConfirm: true,
                  closeOnCancel: true
                },
                function(isConfirm) {
                    if (isConfirm) {
                        var gurl = '{{route("ugift.index")}}/'+ block.data('id') + '?_method=DELETE&project_id=' + block.data('project_id');
                        $.ajax({
                            type : 'POST',
                            url : gurl
                        }).done(function (ret) {
                            if (ret.errors) {
                                console.log(ret.errors);
                            } else if (ret === 'true'){
                                block.remove();
                                swal('','Подарок удалён!','warning');
                            }
                        }).fail(function (ret) {
                            console.log('-- ошибка запроса ', gurl , ret);
                        });
                    }
                });
            return false;
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
                     $('.rewards .js_temp_to_delete').remove();
                     $('.rewards').append(data.gift);
                     swal('','Подарок добавлен!','success');
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