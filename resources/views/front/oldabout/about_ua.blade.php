@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="about_us_page">
                <h2 class="caption">Про нас</h2>
                    <p>Салют, друзі!</p>
                    <p>Ми – молода та креативна команда. Так само, як і ви, ми знаємо, що світ сповнений талановитими людьми, яким часто не вистачає коштів для реалізації своїх ідей. Кожен день в світі народжуються сотні геніальних думок, які так і залишаються без належної уваги. Бракує грошей? Не впевнені в своїй ідеї? Нам не подобається такий підхід. Ласкаво просимо на Dreamstarter!</p>
                    <div class="row">
                        <div class="about_img">
                            <img src="{{asset('images/front/about_infographic.jpg')}}" />
                            <div class="about_infographic infographic_item_1"><h3>Проект</h3></div>
                            <div class="about_infographic infographic_item_2"><h3>Люди</h3></div>
                            <div class="about_infographic infographic_item_3"><h3>Реалізація</h3></div>
                            <div class="about_infographic infographic_item_4"><h3>Результат</h3></div>
                        </div>
                    </div>
                    <p>Завдяки нашій платформі у авторів проектів є чудова можливість продемонструвати людям свої ідеї та отримати необхідне фінансування, а у їхніх спонсорів - стати причетним до чогось значущого і придбати унікальні речі та бонуси.</p>
                    <div class="info-about">
                        <h4>Як це працює?</h4>
                        <img src="{{asset('images/front/info_about.png')}}" alt="">
                    </div>
                    <p>Ми любимо краудфандинг, живемо його ідеями та успіхом кожного нашого проекту. У нас спільна мета, ми готові працювати з нашими авторами 24/7. Ми працюємо не тільки над сьогоденням, а й над майбутнім.</p>
                    <div class="about-get">
                        <h4>Що ви отримуєте?</h4>
                        <div class="about-get-item">
                            <img src="{{asset('images/front/about_us1.png')}}" alt="">
                            <p>Гроші, необхідні для реалізації ідеї</p>
                        </div>
                        <div class="about-get-item">
                            <img src="{{asset('images/front/about_us2.png')}}" alt="">
                            <p>Вірну аудиторію і однодумців</p>
                        </div>
                        <div class="about-get-item">
                            <img src="{{asset('images/front/about_us3.png')}}" alt="">
                            <p>Готову клієнтуру</p>
                        </div>
                        <div class="about-get-item">
                            <img src="{{asset('images/front/about_us4.png')}}" alt="">
                            <p>Безцінний досвід</p>
                        </div>
                        <div class="about-get-item">
                            <img src="{{asset('images/front/about_us5.png')}}" alt="">
                            <p>Впевненість у своїй справі</p>
                        </div>

                    </div>
                    <div class="about-offer">
                        <h4>Що ми пропонуємо?</h4>
                        <div class="about-offer-item">
                            <img src="{{asset('images/front/about_us6.png')}}" alt="">
                            <p>Будь-який проект абсолютно безкоштовний</p>
                        </div>
                        <div class="about-offer-item">
                            <img src="{{asset('images/front/about_us7.png')}}" alt="">
                            <p>Декілька типів проектів</p>
                        </div>
                        <div class="about-offer-item">
                            <img src="{{asset('images/front/about_us8.png')}}" alt="">
                            <p>Наша сервісна комісія складає лише 5% від суми</p>
                        </div>
                        <div class="about-offer-item">
                            <img src="{{asset('images/front/about_us9.png')}}" alt="">
                            <p>Тільки у нас гнучкі умови для досягнення максимального результату вашого проекту.</p>
                        </div>
                    </div>
                    <p>Творіть, створюйте, йдіть до своєї мрії та досягайте поставленої мети разом з нами!</p>
            </div>
        </div>
    </div>
</div>
@endsection