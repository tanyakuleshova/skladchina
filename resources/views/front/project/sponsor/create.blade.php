{{-- Форма для получения награды проекта --}}
{{-- $project , $gift, $summa --}}
@extends('layouts.app')
@section('content')
<section class="wrap">
    <div class="container">
        <div class="get-rewards-form">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="create_title"><span class="greeny">Форма получения награды</span></h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="create_project get-rewards-info">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="get-rewards-info-left">
                                    <h2>{{ $project->name }}</h2>
                                    <div class="rewards_wrap_img">
                                        <img src="{{asset($gift->image)}}"/>
                                    </div>
                                    <div class="rewards_wrap_text">
                                        {!! $gift->description !!}
                                    </div>
                                    <div>
                                        <label>Доставка:</label>
                                        {{ $gift->deliveryMethod }},
                                        {{ $gift->delivery_date }}
                                    </div>
                                    <div class="get-rewards-rules">
                                        <label>Прекрасный выбор! Наши поздравления.</label>
                                        <p>Осталось совсем чуть-чуть. Пожалуйста, заполните эту анкету, это поможет
                                            автору при отправлении награды, а также даст ему возможность связаться с
                                            вами.</p>
                                        <p>Данные, указанные в анкете, будут доступны только для автора проекта и
                                            только в случае его успеха. Информация не предназначена для публичной
                                            огласки.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div>
                                    <label>Email:</label>
                                    {{ Auth::user()->email }}
                                </div>
                                <form action="{{route('support_project.store')}}" method="post">
                                    {{csrf_field()}}
                                    <input type="hidden" name="project_id" value="{{$project->id}}">
                                    <input type="hidden" name="project_gift_id" value="{{$gift->id}}">

                                    <label>Сумма:</label>
                                    <input type="number" class="" name="summa" placeholder="Не менее {{$gift->need_sum}} грн" min="{{$gift->need_sum}}" value='{{ old('summa')?old('summa'):$summa }}' required disabled>

                                    <label>Телефон:</label>
                                    <input type="text" name="phone" value="{{ Auth::user()->account->contact_phone }}">
                                    
                                    @if($gift->isDelivery)
                                    <label>Город:</label>
                                    <input type="text" name="city" value="{{ Auth::user()->city }}">

                                    <label>Адрес:</label>
                                    <input type="text" name="address">
                                    @endif
                                    
                                    <label>Комментарий:</label>
                                    <textarea type="text" name="comment"></textarea>

                                    @if($gift->question_user)
                                    <label>Вопрос от создателей проекта:</label>
                                    <p>{{ $gift->question_user }}</p>
                                    <input type="text" name="ask_question">
                                    @endif
                                    
                                    <div class="get-rewards-right-btn">
                                        <button type="submit" class="btn">Перейти к оплате</button>
                                    </div>
                                    <div class="get-rewards-left-btn">
                                        <a class="btn btn-danger"
                                           href="{{ route('project.show',$project->id)}}"
                                           title="Отказаться">Отказаться</a>
                                    </div>
                                </form>
                                <div class="clearfix"><br/></div>
                                <div class="rewards_wrap_rules">
                                    <p>Нажимая на Перейти к оплате вы соглашаетесь с <a href="/rules_service" target="_blank">Правилами</a> и <a href="/compliance" target="_blank">Условиями пользования</a>.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
<script type="text/javascript" src="{{asset('js/jquery.downCount.js')}}"></script>
<script>
jQuery('document').ready(function ($) {
    $('.downCountTimer').each(function () {
        var deadline = $.trim($(this).find('.hidden').html());
        if (deadline == '')
            return;

        $(this).downCount({date: deadline, });

        //console.log(deadline);         
        //console.log(this);

    });

    $(document).on('submit', '._support_project_', function (e) {
        e.preventDefault();
        var tforma = $(this);
        $.ajax({
            type: "POST",
            url: "{{ route('check_my_balance') }}",
            data: $(tforma).serialize(),
            success: function (msg) {
                if (msg.errors !== undefined) {
                    swal(msg.errors, "error");
                }
                if (msg.success !== undefined) {
                    if (msg.success) {
                        tforma.removeClass('_support_project_');
                        tforma.submit();
                    } else {
                        swal('', 'На балансе не хватает средств', "error");
                    }

                }
            }
        });
    });


});


</script>

@endsection