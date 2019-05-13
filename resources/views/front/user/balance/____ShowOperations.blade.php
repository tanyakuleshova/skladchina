@extends('layouts.app')
@section('content')
<div class="wrap">
    <div class="container">
        <div class="row">
            <div class="col-md-offset-2 col-md-8">
                <div class="about_us_page">
                    <h2 class="caption">Мои финансы</h2>
                    @if($b_first)
                        <p>Первая операция :{{ $b_first->created_at }}</p>
                    @else
                        <p>Ещё не было операций</p>
                    @endif
                    
                    @if($b_last && $b_first && ($b_first->id != $b_last->id))
                        <p>Последняя операция :{{ $b_last->created_at }}</p>
                    @endif
                </div>
                
                <div>
                    Текущий баланс : {{ $b_balance }} грн.
                </div>
            </div>
            <div class="col-md-offset-2 col-md-8">
                <br/>
                <a href="#" class="btn" id="btn_add_balance">Пополнить баланс</a>
                <br/><br/>
                <a href="{{ route('mybalance.index')}}" class="btn">Мои финансовые операции операции</a>
                <br/><br/>
                <a href="{{ route('support_project.index')}}" class="btn ">Отказаться от поддержки проекта</a>
                <br/><br/>
                <a href="{{ route('refund.index')}}" class="btn">Заявка на возврат средств</a>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="user_add_balance" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
            <div class="modal-body" id="body_user_add_balance"></div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function($){
        $('#body_user_add_balance').empty();
        
        $('#btn_add_balance').on('click',function(){
            $('#body_user_add_balance').load('{{ route("mybalance.create")}}',function(){
                $('#user_add_balance').modal('show');
            });
        });

        $('#user_add_balance').on('hidden.bs.modal', function (e) {
            $('#body_user_add_balance').empty();
        })
        
        $(document).on('submit','#form_add_balance', function(e){
            e.preventDefault();
            var tforma = this;
            $.ajax({
              type: "POST",
              url: "{{ route('mybalance.store') }}",
              data: $(tforma).serialize(),
              success: function(msg){
                if (msg.errors !== undefined ) { 
                    alert(msg.errors);
                }
                if (msg.forms !== undefined) {
                    $(tforma).after(msg.forms);
                    $(msg.forms).submit();
                }
              }
            });
            
            
        })
        
        
    });


</script>

@endsection