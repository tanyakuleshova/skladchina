@extends('layouts.app')
@section('title', trans('meta.curatorstitle'))
@section('meta-description', trans('meta.curatorsdesc'))
@section('content')
<div class="infographic about_us_page">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div>
					<h2 class="caption">Кураторы</h2>
					<h4>Кто такие кураторы проектов?</h4>
					<p>Кураторы – это компании и организации, которые помогают нашим проектам в их продвижении, материальном обеспечении и/или реализации. 
					Каждый раз, когда любой проект набирает 20% от заявленной суммы, он отправляется на рассмотрение всем кураторам. 
					Кураторы сами решают интересен им проект или нет. В случае заинтересованности обеих сторон, куратор закрепляется за выбранным проектом, а перед описанием размещается небольшой баннер с 
					логотипом куратора.</p>
					<h4>Сколько это стоит?</h4>
					<p>Нисколько. Мы ищем кураторов только для помощи нашим проектам. При этом куратор не может рассчитывать на какое-либо финансовое вознаграждение.</p>
					<h4>Как стать куратором?</h4>
					<p>Со всеми кураторами платформа заключает партнерское соглашение, которое определяет возможности и обязанности каждой из сторон. 
					Пишите на <a href="mailto:support@dreamstarter.com.ua">support@dreamstarter.com.ua</a>, в теме сообщения указывайте «Куратор».</p>
				</div>
			</div>
			<div class="col-md-12">
				<div class="curators-logo">
					<div>
						<a href="http://divotek.com"><img src="{{asset('images/front/curators_logo.png')}}"></a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection