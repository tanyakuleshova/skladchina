@extends('layouts.app')
@section('content')
    <section class="rules_created_project">
        <div class="container">
            @if(Session::has('success_message'))
            <div class="row">
                <div class="alert alert-success">{{Session::get('success_message')}}</div>
            </div>
            @endif
            @if(Session::has('warning_message'))
            <div class="row">
                <div class="alert alert-warning">{{Session::get('warning_message')}}</div>
            </div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="money_wrap">
                        <h2 class="caption"><span class="greeny">{!!trans('createproject.ruleshead')!!}</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="rules_page_wrap">
                        <div class="rules_page">
                            <h2 class="rules_page_title">Забороняються проекти, які:</h2>
                            <ul class="rules_page_block">
                                <li><span>Переслідують особисту мету, яка не має нічого спільного з творчою або суспільно корисною діяльністю;</span></li>
                                <li><span>Водночас розміщені на аналогічних платформах, які використовують принцип краудфандингу;</span></li>
                                <li><span>Не відповідають морально-етичним нормам суспільства;</span></li>
                                <li><span>Пов’язані з релігійною або політичною діяльністю;</span></li>
                                <li><span>Не відповідають цілям та завданням, визначеним в Умовах користування та Правилах;</span></li>
                                <li><span>Суперечать чинному законодавству України;</span></li>
                            </ul>
                            <h2 class="rules_page_title">Ви можете запустити свій проект, якщо:</h2>
                            <ul class="rules_page_check">
                                <li><span>Вам виповнилося 18 років;</span></li>
                                <li><span>У вас є діючий рахунок у банку;</span></li>
                                <li><span>Ви або ваша компанія відповідаєте вимогам, які встановлені <a href="">Умовами користування</a> та <a href="">Правилами;</a></span></li>
                            </ul>
                            <h2 class="rules_page_title">Ваш проект буде допущений до проведення краудфандингової кампанії, якщо:</h2>
                            <ul class="rules_page_check">
                                <li><span>Чітко сформульовані цілі і умови, які відповідають <a href="#">Правилам</a> та <a href="#">Умовам користування.</a></span></li>
                                <li><span>Вказана фінансова мета проекту та/або його часові рамки.</span></li>
                                <li><span>Визначені винагороди для учасників проекту і умови їх отримання.</span></li>
                            </ul>
                            <h2 class="rules_page_title">Як відбувається створення проекту?</h2>
                            <div class="rules_page_infographic">
                                <div class="item item1">
                                    <div class="item_img item_img1">
                                        <img src="{{asset('images/front/regulations_img1.png')}}" alt="">
                                    </div>
                                    <img src="{{asset('images/front/regulations_number1.png')}}" alt="">
                                    <p>Ви заповнюєте всі існуючі поля в конструкторі проектів.</p>
                                </div>
                                <div class="item item2">
                                    <div class="item_img item_img2">
                                        <img src="{{asset('images/front/regulations_img2.png')}}" alt="">
                                    </div>
                                    <img src="{{asset('images/front/regulations_number2.png')}}" alt="">
                                    <p>Проект вирушає на розгляд модераторам платформи.</p>
                                </div>
                                <div class="item item3">
                                    <div class="item_img item_img3">
                                        <img src="{{asset('images/front/regulations_img3.png')}}" alt="">
                                    </div>
                                    <img src="{{asset('images/front/regulations_number3.png')}}" alt="">
                                    <p>Якщо проект вимагає правок або доробок - працюємо над цим.</p>
                                </div>
                                <div class="item item4">
                                    <div class="item_img item_img4">
                                        <img src="{{asset('images/front/regulations_img4.png')}}" alt="">
                                    </div>
                                    <img src="{{asset('images/front/regulations_number4.png')}}" alt="">
                                    <p>З вами зв'язується ваш особистий менеджер для оформлення угоди про умови співробітництва з Dreamstarter.</p>
                                </div>
                                <div class="item item5">
                                    <div class="item_img item_img5">
                                        <img src="{{asset('images/front/regulations_img5.png')}}" alt="">
                                    </div>
                                    <img src="{{asset('images/front/regulations_number5.png')}}" alt="">
                                    <p>Після того, як всі деталі вашого проекту будуть узгоджені, проект може бути запущений.</p>
                                </div>
                            </div>
                            <div class="attention"><img src="{{asset('images/front/attention_img.png')}}"><p>Якщо в процесі створення проекту у вас виникнуть питання, пишіть на адресу <a href="#">support@dreamstarter.com.ua.</a> Створити проект може тільки зареєстрований користувач.</p>
                            </div>
                        </div>
                        <form action="{{'first_step_add_project'}}" method="post">
                            <div class="check">
                                <span class="icon"></span>
                                {{csrf_field()}}
                                <input type="checkbox" name="confirm_with_rules" class="dvf-target" />
                                <label>Я приймаю умови <a href="">Угоди користувача</a>.</label>
                            </div>
                            <button class="project_next">вперед<img src="{{asset('images/front/create_next_btn.png')}}" height="11" width="7" alt=""></button>
                        </form>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="rules_page_navbar">
                        <h3>Зареєструвати проект можна, якщо:</h3>
                        <ul>
                            <li><span>Вам виповнилось 18 років;</span></li>
                            <li><span>Ви можете надати документи, що підтверджують особу, і відомості про місце проживання;</span></li>
                            <li><span>У вас є відкритий банківський рахунок, кредитна чи дебетова карта.</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection