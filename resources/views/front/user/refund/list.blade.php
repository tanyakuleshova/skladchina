@extends('layouts.app')
@section('title','Заявки на возврат средств')
@section('content')
<div class="wrapper">
    <div class="container"> 
        <div class="row">
            <div class="refund-balance-wrap">
                @if(!$rlist->isEmpty())
                <div class="ibox-title text-center">
                    <h3>Заявки на возврат средств</h3>
                </div>
                <div class="ibox-content">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>№</th>
                                <th>Сумма</th>
                                <th>валюта</th>
                                <th>Куда</th>
                                <th>Статус</th>
                                <th>Создана</th>
                                <th>&nbsp;&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>   
                            @foreach($rlist as $operation)
                            <tr>
                                <td>{{ $operation->id }}</td>
                                
                                <td>{{ $operation->summa }}</td>
                                
                                <td>{{ $operation->currency->name }}</td>

                                <td>{{ $operation->userpaymethod->name }}</td>
                                
                                <td>{{ $operation->status->name }}</td>
                                
                                <td>{{ $operation->created_at }}</td>

                                <td>
                                    <a class="btn btn-primary btn_show"
                                    href="{{ route('refund.show',$operation->id) }}"
                                    title="Просмотреть детальную информацию"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $rlist->links() }}
                </div>
                @else
                <div class="ibox-title text-center">
                    <h3>У Вас нет заявок на вывод средств</h3>
                </div>
                @endif
            </div>    
        </div>
        <div class="row">
            <div class="refund-balance-btn">
                <a href="{{route('refund.create')}}" class="btn btn-danger">Подать заявку, заполнить форму</a>
                <a href="{{ route('mybalance.index') }}" class="btn btn-info">Назад, Мои финансы</a>    
            </div>
        </div>
    </div>
</div>  
@endsection
