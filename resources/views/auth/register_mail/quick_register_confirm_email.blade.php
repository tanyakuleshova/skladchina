<div style="background-color: #d1d1d1; padding: 60px 0">

    <table border="0" cellpadding="0" cellspacing="0" style="width: 100%; margin: 0 auto; max-width: 600px; font-family:Arial, sans-serif; background-color: #ffffff;">
        <tbody>
            <tr>
                <td style="text-align: left;">
                    <a href="https://dreamstarter.com.ua" style="text-decoration:none; padding: 20px 30px; display: block;" target="_blank">         
                        <img src="https://dreamstarter.com.ua/storage/email/logo-beta.png" title="dreamstarter.com.ua" border="0" alt="Dreamstarter" style="max-width: 100%; height: auto;"> 
                    </a>
                </td>
                <td style="text-align: right; padding: 30px;">
                    <a href="https://www.instagram.com/dreamstarter.com.ua/" style="text-decoration:none;"> 
                        <img src="https://dreamstarter.com.ua/storage/email/insta.png" alt="профиль инстаграм">
                    </a>
                    <a href="https://facebook.com/dreamstarter.com.ua" style="text-decoration:none;">
                        <img src="https://dreamstarter.com.ua/storage/email/fb.png" alt="страница facebook"/>
                    </a>
                    <a href="https://twitter.com/dreamstarter_ua" style="text-decoration:none;">
                        <img src="https://dreamstarter.com.ua/storage/email/tw.png" alt="блог twitter"/>
                    </a>
                    <a href="https://www.youtube.com/channel/UCOv471RNee6aC_rUKeW-jvQ" style="text-decoration:none;">
                        <img src="https://dreamstarter.com.ua/storage/email/youtube.png" alt="канал youtube"/>
                    </a>
                </td>
            </tr>

            <tr>
                <td colspan="2" style="text-align: left; padding: 20px 30px; font-size:16px; line-height: 1.4;">
                    <h2 style="font-size: 20px; color: #595959; margin: 0 0 20px;"><b>Здравствуйте <span style="color: #06c8f8;">{{ $name }} !</span></b></h2>
                    <p style=" margin: 0 0 10px;">Вы успешно прошли регистрацию на Dreamstarter. Для дальнейшей работы с платформой, пожалуйста, подтвердите адрес электронной почты. Пользователи, не подтвердившие актуальность электронного адреса, не могут использовать все функции платформы.</p>

                    <p style=" margin: 0 0 10px;"> Для входа в личный кабинет используйте вашу электронную почту и пароль <b>{{ $password }}</b> </p>
                     <p style=" margin: 0 0 10px;"> Чтобы изменить пароль войдите в личный кабинет в закладку безопасность </p>
                    
                    <div style=" margin: 30px 0 30px; text-align: center;">


                        <a href="{{route('confirmation', $email_token)}}" style=" margin:0 0 4px; display: inline-block; padding: 11px 15px; text-decoration: none; text-transform: uppercase; font-weight: bold; font-size: 15px; background-color: #07d9e8; color: #fff;">Подтвердить e-mail</a>

                    </div>



                    <p style=" margin: 0 0 10px;">Если у вас возникли трудности при переходе по ссылке, скопируйте этот адрес в буфер обмена и вставьте его в адресную строку вашего браузера:

                    </p>

                   <div style=" margin: 15px 0 30px; text-align: center;">
                   <i style="color: #777; font-size: 16px;">{{route('confirmation', $email_token)}}</i>
                    </div>

                    <p style=" margin: 0 0 10px; ">Ссылка для подтверждения e-mail действительна в течение 5-ти дней. Если же вы не совершали никаких действий, пожалуйста, проигнорируйте это письмо.</p>

                    <p style=" margin: 0 0 10px; ">На все Ваши вопросы с радостью ответит администратор сайта и сообществ социальных сетей.</p>


                    <p style="font-size:16px; line-height: 1; text-align: right;  color: #999;"><i>Всегда ваш,</i><br><i>Dreamstarter</i>
                    </p>

                </td>
            </tr>
        </tbody>
    </table>
</div>