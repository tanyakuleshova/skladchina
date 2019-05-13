@extends('layouts.app')
@section('title', trans('meta.abouttitle'))
@section('meta-description', trans('meta.aboutdesc'))
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="about_us_page">
                <h2 class="caption">О нас</h2>
                    <p>Салют, друзья!</p>
                    <p>Мы &ndash; молодая и креативная команда. Также, как и вы, мы знаем, что мир полон талантливых людей, которым зачастую не хватает средств для реализации своих идей. Каждый день в мире рождаются сотни гениальных мыслей, которые так и остаются без должного внимания. Не хватает денег? Не уверены в своей идее? Нам не нравится такой подход. Добро пожаловать на Dreamstarter!</p>
                    <div class="row">
                        <div class="about_img">
                            <img src="{{asset('images/front/about_infographic.jpg')}}" />
                            <div class="about_infographic infographic_item_1"><h3>Проект</h3></div>
                            <div class="about_infographic infographic_item_2"><h3>Люди</h3></div>
                            <div class="about_infographic infographic_item_3"><h3>Реализация</h3></div>
                            <div class="about_infographic infographic_item_4"><h3>Результат</h3></div>
                        </div>
                    </div>
                    <p>Благодаря нашей платформе у авторов проектов есть прекрасная возможность продемонстрировать людям свои идеи и получить необходимое финансирование, а у их спонсоров &ndash; стать сопричастным к чему-то значимому и приобрести уникальные вещи и бонусы.</p>
                    <div class="info-about">
                        <h4>Как это работает?</h4>
                        <img src="{{asset('images/front/info_about.png')}}" alt="">
                    </div>
                    <p>Мы любим краудфандинг, живем его идеями и успехом каждого нашего проекта. У нас общая цель, мы готовы работать с нашими авторами 24/7. Мы работаем не только над настоящим, но и над будущим.</p>
                    <div class="about-get">
                        <h4>Что вы получаете?</h4>
                        <div class="about-get-item">
                            <img src="{{asset('images/front/about_us1.png')}}" alt="">
                            <p>Деньги, необходимые для реализации идеи</p>
                        </div>
                        <div class="about-get-item">
                            <img src="{{asset('images/front/about_us2.png')}}" alt="">
                            <p>Верную аудиторию и единомышленников</p>
                        </div>
                        <div class="about-get-item">
                            <img src="{{asset('images/front/about_us3.png')}}" alt="">
                            <p>Готовую клиентуру</p>
                        </div>
                        <div class="about-get-item">
                            <img src="{{asset('images/front/about_us4.png')}}" alt="">
                            <p>Бесценный опыт</p>
                        </div>
                        <div class="about-get-item">
                            <img src="{{asset('images/front/about_us5.png')}}" alt="">
                            <p>Уверенность в своём деле</p>
                        </div>

                    </div>
                    <div class="about-offer">
                        <h4>Что мы предлагаем?</h4>
                        <div class="about-offer-item">
                            <img src="{{asset('images/front/about_us6.png')}}" alt="">
                            <p>Любой проект абсолютно бесплатный</p>
                        </div>
                        <div class="about-offer-item">
                            <img src="{{asset('images/front/about_us7.png')}}" alt="">
                            <p>Несколько типов проектов</p>
                        </div>
                        <div class="about-offer-item">
                            <img src="{{asset('images/front/about_us8.png')}}" alt="">
                            <p>Наша сервисная комиссия составляет лишь 5% от суммы</p>
                        </div>
                        <div class="about-offer-item">
                            <img src="{{asset('images/front/about_us9.png')}}" alt="">
                            <p>Только у нас гибкие условия для достижения максимального результата вашего проекта</p>
                        </div>
                    </div>
                    <p>Творите, создавайте, идите к своей мечте и добивайтесь поставленных целей вместе с нами!</p>
            </div>
        </div>
    </div>
</div>
@endsection