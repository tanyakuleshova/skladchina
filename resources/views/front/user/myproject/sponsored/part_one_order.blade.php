{{-- на входе Order $order--}}

<?php 
    $phone = $order->user->account->contact_phone;
    if ($order->userfields && isset($order->userfields['phone'])) {$phone = $order->userfields['phone'];}
    $city = null;
    $adress = null;
    if ($order->gift && $order->gift->isDelivery) {
        $city = ($order->userfields && isset($order->userfields['city']))?$order->userfields['city']:$order->user->account->city_birth;
        $adress = ($order->userfields && isset($order->userfields['address']))?$order->userfields['address']:null;
    }
    $comment = ($order->userfields && isset($order->userfields['comment']))?$order->userfields['comment']:null;
    $ask_question = ($order->userfields && isset($order->userfields['ask_question']))?$order->userfields['ask_question']:null;
    
    $status = null;
    if($order->history && isset($order->history['send'])) {
        $status = $order->history['send'];
    }
?>

<table cellpadding="4" cellspacing="0" border="0" style="padding-left:50px;">

    <tr>
        <td>Телефон</td>
        <td>{{ $phone }}</td>
        <td></td>
        <td>{{ $order->usergifts?$order->gift->deliveryMethod:'Без вознагрождения' }}</td>
    </tr>

    
    @if($city || $adress)
    <tr>
        <td>Город</td>
        <td>{{ $city }}</td>
        <td>Адрес</td>
        <td>{{ $adress }}</td>
    </tr>
    @endif

    <tr>
        <td>Комментарий</td>
        <td colspan="3">{{ $comment?$comment:' -нет комментариев-' }}</td>
    </tr>

    
    @if($ask_question)
    <tr>
        <td>ВОПРОС</td>
        <td>{{ ($order->gift && $order->gift->question_user)?$order->gift->question_user:'' }}</td>
        <td>ОТВЕТ</td>
        <td>{{ $ask_question }}</td>
    </tr>
    @endif
    
    @if($order->gift && $order->gift->isImage)
    <tr>
        <td colspan="5">
            <img src="{{asset($order->gift->image)}}"/>
        </td>
    </tr>
    @endif
    
    @if(!$status)
    <tr>
        <td colspan="5">
            <label for="send">Отметить отправку вознаграждения пользователю</label>
            <input type="checkbox" name="send" onclick="checkSendGift(this);" value="{{ $order->id}}"/>
        </td>
    </tr>
    @endif
    
</table>