@extends('layouts.app')
@section('title', trans('meta.returntitle'))
@section('meta-description', trans('meta.returndesc'))
@section('content')
<div class="container returnmoney rules_services">
	<div class="row">
		<div class="col-md-12">
			<h2 class="caption">Возврат средств</h2>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<p>Возврат денежных средств осуществляется только пользователю, оплатившему заказ, и только на расчётный счёт или электронный кошелёк, с которого производилась оплата.</p>
			<p>Для возврата следуйте простой инструкции:</p>
			<ul>
				<li><span>Скачайте Заяву про повернення коштів.</span></li>
				<li><span>Распечатайте Заяву про повернення коштів и заполните в соответствии с назначением полей. В Заявлении необходимо указать:</li>
				<ul>
					<li><span>ФИО (без сокращений);</span></li>
					<li><span>паспортные данные пользователя;</span></li>
					<li><span>телефон, электронную почту;</span></li>
					<li><span>номер и дату заказа</span></li>
					<li><span>реквизиты счёта (расчётный счёт, номер карты, код банка, фамилия и имя владельца) или номер электронного кошелька, с которых был оплачен заказ. Проверить номер кошелька вы можете, зайдя на сайт платежной системы, через которую был осуществлен платеж;</span></li>
					<li><span>дату и подпись.</span></li>
				</ul>
				<li><span>Документ должен быть заполнен от руки, синей пастой и печатными буквами.</span></li>
				<li><span>Прикрепите скан-копию Заяви про повернення коштів в соответствующем окне и отправьте заявление.</span></li>
			</ul>
			<h5>ВНИМАНИЕ!</h5>
			<p>&ndash; В случае обоснованных сомнений могут быть потребованы дополнительные документы.</p>
			<h5>ВНИМАНИЕ!</h5>
			<p>&ndash; Для каждого заказа заполняется отдельное заявление.</p>
			<h5>ВНИМАНИЕ!</h5>
			<p>&ndash; За возврат денежных средств по неверно указанным получателем реквизитам ТОВ &laquo;ДРІМСТАРТЕР ГРУП&raquo; ответственности не несет.</p>
			<p>Возврат денежных средств осуществляется в период <h5>от 3 до 10 рабочих дней</h5> с момента получения корректного Заявления.</p>
			<p>Если у вас возникли вопросы &ndash; обязательно пишите на <a href="mailto:support@dreamstarter.com.ua">support@dreamstarter.com.ua</a>, мы с радостью вам ответим!</p>
		</div>
	</div>
</div>
@endsection