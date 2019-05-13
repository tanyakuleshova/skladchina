@extends('layouts.app')
@section('title','Мои финансы')
@section('content')
<div class="wrapper">
    <div class="container">
        <div class="balance-wrap">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="text-center">Мои финансы</h1>
                </div>
                <div class="col-md-4">
                    <div class="balance-top-block">
                        <div class="balance-top-info">
                            <h3>Баланс</h3>
                            <span>{{ number_format (Auth::user()->getMyBalance(),0,'.',' ') }} &#8372;</span>
                        </div>
                        <a href="#" class="btn btn-balance" id="btn_add_balance">Пополнить</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="balance-top-block">
                        <div class="balance-top-info">
                            <h3>Поддержанные</h3>
                            <span>{{ Auth::user()->getSponsoredProjects()->count()?:'-' }}</span>
                        </div>
                        @if(!Auth::user()->getSponsoredProjects()->isEmpty())
                        <a href="{{ route('support_project.index')}}" class="btn btn-refusal">Отказаться от поддержки проекта</a>
                        @else
                        <a class="btn btn-refusal disabled" title="Нет проектов для отказа">Отказаться от поддержки проекта</a>
                        @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="balance-top-block">
                        <div class="balance-top-info">
                            <h3>Мои заявки</h3>
                            <span>{{ Auth::user()->refund()->count()?:'-' }}</span>
                        </div>
                        @if(Auth::user()->getMyBalance())
                        <a href="{{ route('refund.index')}}" class="btn btn-refund">Заявка на возврат средств</a>
                        @else
                        <a class="btn btn-refund disabled" title="Нет доступных средств">Заявка на возврат средств</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                @if($balancies->total())
                <h2 class="caption">Мои операции</h2>
                <div class="ibox-content">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>№</th>
                                <th>Сумма</th>
                                <th>Тип</th>
                                <th>Статус</th>
                                <th>Создана</th>
                                <!--th>&nbsp;&nbsp;</th-->
                            </tr>
                        </thead>
                        <tbody>   
                            @foreach($balancies as $operation)
                            <tr>
                                <td data-label="№:">{{ $operation->id }}</td>
                                <td data-label="Сумма:">{{ number_format ($operation->summa,0,'.',' ') }}</td>
                                <td data-label="Тип:">{{ $operation->type->name }}</td>
                                <td data-label="Статус:">{{ $operation->status->name }}</td>
                                <td data-label="Создана:">{{ $operation->created_at }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $balancies->links() }}
                </div>
                @else
                <h2 class="caption">У вас ещё не было финансовых операций</h2>
                @endif
            </div>
        </div>
    </div>
    <div class="modal fade balance-modal" id="user_add_balance" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="title">{{trans('user_profile.addmoneyfor')}} {{Auth::user()->name}}</span>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body" id="body_user_add_balance"></div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
<script>
$(document).ready(function ($) {
    $('#body_user_add_balance').empty();

    $('#btn_add_balance').on('click', function () {
        $('#body_user_add_balance').load('{{ route("mybalance.create")}}', function () {
            $('#user_add_balance').modal('show');
        });
    });

    $('#user_add_balance').on('hidden.bs.modal', function (e) {
        $('#body_user_add_balance').empty();
    })

    $(document).on('submit', '#form_add_balance', function (e) {
        e.preventDefault();
        var tforma = this;
        $.ajax({
            type: "POST",
            url: "{{ route('mybalance.store') }}",
            data: $(tforma).serialize(),
            success: function (msg) {
                if (msg.errors !== undefined) {
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