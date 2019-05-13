@extends('layouts.app')
@section('title', trans('meta.contactstitle'))
@section('meta-description', trans('meta.contactsdesc'))
@section('content')
<div class="infographic contacts">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="caption">Контакты</h2>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="contacts_wrap">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-8 pull-left">
                            <p>Спрашивайте. Мы ответим так быстро, как только сможем!</p>
                            <br>
                            <p>Если вы хотите поделиться советами для сайта, идеями проекта или же просто рецептом бабушкиного пирога – сделайте это. Обратная связь гарантирована.</p>
                            <p>&nbsp;</p>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4 pull-right">
                            <div class="contacts_nav">
                                <div class="contacts_nav_wrap">
                                    <h4>E-mail</h4>
                                    <a href="mailto:support@dreamstarter.com.ua"><i class="fa fa-envelope"></i> support@dreamstarter.com.ua</a>
                                </div>
                                <!--div class="contacts_nav_wrap">
                                    <h4>Телефон</h4>
                                    <a href="tel:+380669293436"><i class="fa fa-phone"></i> +38(066)959-34-36</a>
                                </div-->
                                
                                    
                                    <div class="contact_social_wrap">
                                        <h4>Социальные сети</h4>
                                        <div class="contact_social col-md-5">
                                            <a href="https://www.facebook.com/dreamstarter.com.ua/" target="_blank"><i class="fa fa-facebook"></i> Facebook</a>
                                        </div>
                                        <div class="contact_social col-md-5 col-md-offset-2">
                                            <a href="https://twitter.com/dreamstarter_ua" target="_blank"><i class="fa fa-twitter"></i> Twitter</a>
                                        </div>
                                        <div class="contact_social col-md-5">
                                            <a href="https://www.instagram.com/dreamstarter.com.ua/" target="_blank"><i class="fa fa-instagram"></i> Instagram</a>
                                        </div>
                                        <div class="contact_social col-md-5 col-md-offset-2">
                                            <a href="https://www.youtube.com/channel/UCOv471RNee6aC_rUKeW-jvQ" target="_blank"><i class="fa fa-youtube-play"></i> Youtube</a>
                                        </div>
                                    </div>
                                
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-8 pull-left">
                            <form action="{{ route('contactssend') }}" method="post" class="contactspage">
                                {{csrf_field()}}
                                <div class="form-group col-md-6">
                                
                                <input name="name" type="text" placeholder="Имя" required="" value="{{ old('name')}}">
                                @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                                </div>
                                <div class="form-group col-md-6">
                                
                                <input name="email" type="email" placeholder="E-mail" required=""  value="{{ old('email')}}">
                                @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                                </div>
                                <div class="form-group col-md-12">
                                
                                <textarea name="smessage" rows="4" placeholder="Сообщение" required="">{{ old('smessage')}}</textarea>
                                @if ($errors->has('smessage'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('smessage') }}</strong>
                                </span>
                                @endif                                
                                </div>
                                <div class="buttons_project form-group col-md-12">
                                    <button type="submit" class="btn contats_btn">Отправить</button>
                                </div>

                            </form>
                        </div>
                        
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
@endsection