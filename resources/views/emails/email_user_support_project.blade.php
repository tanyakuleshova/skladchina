<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<div style="background-color: #d1d1d1; padding: 60px 0 60px">
	<div style="margin: 0 auto; max-width: 612px; font-family:Arial,sans-serif; background-color: #f9f6f8;">
		<div style="border: 4px solid #cccccc;">
			<div style="border: 4px solid #c7c7c7;">
				<div style="border: 4px solid #f5f6f6;">

					<table border="0" cellpadding="0" cellspacing="0" style="width: 100%;" style="font-family:Arial,sans-serif;">
						<tbody>
						<tr>
							<td style="text-align: left; padding: 20px 30px">
								<a href="http://dreamstarter.com.ua" style="text-decoration:none" target="_blank">
									<img src="http://dreamstarter.com.ua/images/front/DreamstarterBeta.png" width="150" title="dreamstarter.com.ua" border="0" alt="Dreamstarter" style="min-height:auto !important;border:0;color:#02cbf7 !important;font-family:Arial,sans-serif;font-size:18px;font-weight:bold;outline:none;text-align:center;text-decoration:none"  />
								</a>
							</td>
							<td style="text-align: right; padding: 20px; width: 200px">
								<p style="text-align: center; margin: 5px; color: #595959; font-family: Arial, sans-serif; font-size: 16px; font-weight: 600; margin-top: 8px">Подпишитесь на нас</p>
								<p style="text-align: center; margin: 5px">
									<a href="#" style="text-decoration: none; color: #02cbf7; padding: 7px; font-size: 20px"><i class="fa fa-instagram"></i></a>
									<a href="#" style="text-decoration: none; color: #02cbf7; padding: 7px; font-size: 20px"><i class="fa fa-facebook"></i></a>
									<a href="#" style="text-decoration: none; color: #02cbf7; padding: 7px; font-size: 20px"><i class="fa fa-twitter"></i></a>
								</p>
							</td>
						</tr>
						</tbody>
					</table>

					<div style="padding: 0 5px;">
						<div style="max-width: 500px; margin: 0 auto;">
							<!--h2 style="font-size: 20px; color: #595959">Ваш заказ №, {{ $order->id }} .</h2-->
                                                        <p style="font-size:14px; line-height: 1.5; margin: 5px 0"><b>{{ $user_name }}</b>, теперь вы - спонсор проекта <b>"{!! $project_name !!}"</b></p>
							<!--p style="font-size:14px; line-height: 1.5; margin: 5px 0">Получатель: {{ $user_name }}</p-->
							<!--p style="font-size:14px; line-height: 1.5; margin: 5px 0">Email: {{ $order_email }}</p-->
                                                        <p style="font-size:14px; line-height: 1.5; margin: 5px 0">Номер платежа: {{ $order->id }}</p>
							<p style="font-size:14px; line-height: 1.5; margin: 5px 0">Сумма: {{ $order->summa }} грн.</p>
							<!--p style="font-size:14px; line-height: 1.5; margin: 5px 0">Телефон:</p-->
							<!--p style="font-size:14px; line-height: 1.5; margin: 5px 0">Комментарий: </p-->
							<!-- <div style="text-align: center; margin: 30px 0;">
								<a href="#" style="padding: 12px 30px; border-radius: 3px; text-decoration: none; text-transform: uppercase; font-weight: normal;font-size: 12px;background-color: #02cbf7; color: #fff;">Подтвердить e-mail</a>
							</div> -->
							<!-- <p style="font-size:14px; line-height: 1.5; margin: 5px 0">Если у вас возникли трудности при переходе по ссылке, скопируйте этот адрес в буфер обмена и вставьте его в адресную строку вашего браузера:</p>
							<p style="font-size:14px; line-height: 1.5; text-align: center; margin: 5px 0"><a href="http://www.dreamstarter.com.ua" style="text-decoration: none; color: #02cbf7;">dreamstarter.com.ua</a></p>
							<p style="font-size:14px; line-height: 1.5; margin: 5px 0">Ссылка для подтверждения e-mail действительна в течение 5-ти дней.
							Если же вы не совершали никаких действий, пожалуйста, проигнорируйте это письмо.
							</p> -->
							<p style="font-size:14px; line-height: 1.5; margin: 5px 0">На все Ваши вопросы с радостью ответит администратор сайта и сообществ социальных сетей.</p>
							<p style="font-size:14px; line-height: 1.5; text-align: right;"><i>Всегда Ваш, Dreamstarter.</i></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

