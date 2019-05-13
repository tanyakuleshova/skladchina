@extends('admin.layouts.admin-app')
@section('admin_content')
<div class="wrapper wrapper-content">

    <div class="row">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Заявки на выплаты</h5>
            </div>
            <div class="ibox-content">

                <h3>{{trans('user_profile.zajava')}}</h3>

                <div>
                    <img class="media_profile img-responsive"
                         src="{{ Storage::url($refund->declaration) }}" 
                         alt="Заявка">
                </div>
            </div>

            <div class="ibox-content">
                <div class="row">
                    <div class="col-md-6">
                        <label>Пользователь</label>
                        <p><a href="{{route('users.show',$refund->user->id)}}">{{ $refund->user->fullName }}</a></p>
                        
                        <label>Текущий баланс пользователя</label>
                        <p>{{ $refund->user->getMyBalance() }} грн.</p> 

                        <label>Дата подачи</label>
                        <p>{{ $refund->created_at }}</p>

                        <label>{{trans('user_profile.summ')}}</label>
                        <p>{{ $refund->summa }} {{ $refund->currency->langOf()->name}}
                            @if($refund->isPending && !$refund->user->checkmybalance($refund->summa))
                            &nbsp;&nbsp;&nbsp;<span class="text-danger">Не достаточно средств на балансе</span>
                            @endif
                        </p>
                        


                        <label>{{trans('user_profile.datacard')}}</label>
                        <p>{{ $refund->userpaymethod->name }} {{ $refund->userpaymethod->code }}</p>
                        @if($refund->userpaymethod->description)
                        <p>{{ $refund->userpaymethod->description }}</p>
                        @endif

                        @if($refund->declaration_text)
                        <label>Уточнения от пользователя</label>
                        <p>{{ $refund->declaration_text }}</p>
                        @endif

                    </div>

                    <div style="col-md-6">

                        <label>Статус</label>
                        <p>{{ $refund->status->name }}</p>


                        @if($refund->status->id !=1)
                        <label>Дата ответа</label>
                        <p>{{ $refund->updated_at }}</p>
                        @endif  

                        @if($refund->admin)
                        <label>Адиминистратор</label>
                        <p>{{ $refund->admin->name }}</p>
                        @endif

                        @if($refund->admin_text)
                        <label>Комментарий администратора</label>
                        <p>{{ $refund->admin_text }}</p>
                        @endif

                        @if($refund->balance)
                        <label>Номер в записи баланса</label>
                        <p>{{ $refund->balance->id }}</p>
                        @endif
                    </div>

                </div>

            </div>




            @if($refund->isPending)
            <div class="ibox-footer bg-info">
                <label for="admin" class="control-label">Администратор, {{ Auth::guard('admin')->user()->fullName }}</label>
                <hr/>
                <form action="{{route('a_refund.update',$refund->id)}}" method="post">
                    {{csrf_field()}}
                    {{ method_field('PUT') }}

                    <div class="form-group">
                        <label for="action" class="control-label">Изменить статус выплаты</label>
                        <select class="form-control bg-warning" name="action">
                            <option disabled selected>Выбирите действие</option>
                            <option value="approved">Выплата произведена</option>
                            <option value="rejected">Отменить</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="admin_text" class="control-label">Комментарий к выплате:</label>
                        <input type="text" name="admin_text" class="form-control text-danger">
                    </div>

                    <button class="btn btn-danger">Внести изменения</button>
                </form>            
            </div>
            @endif



            <div class="ibox-footer">
                <a class="btn btn-info"
                   href="{{route('a_refund.index')}}">Назад, к списку выплат</a>

            </div>
        </div>
    </div>


</div>
@endsection