</div> <!-- close wrap header -->
<footer>
    <div id="toTop"><i class="fas fa-angle-up"></i></div>
    <div class="container">
            <div class="logo">
                <a href="{{url('/home')}}">
                    <img src="{{asset('images/front/DreamstarterBeta.png')}}" width="165" height="64">
                </a>
            </div>
            <div class="footer-info">
                <div class="row footer-info_menu">
                    <div class="col-md-3 col-sm-6">
                        <h4>{{trans('footer.pronas')}}</h4>
                        <ul>

                            <li><a href="{{route('about')}}">{{trans('footer.whatsdream')}}</a></li>
                            <li><a href="{{route('contacts')}}">{{trans('footer.contacts')}}</a></li>
                            <!-- <li><a href="#">Кольори та логотипи</a></li> -->
                        </ul>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <h4>{{trans('footer.sponsors')}}</h4>
                        <ul>

                            <li><a href="{{route('projects')}}">{{trans('footer.allprojects')}}</a></li>
                            <li><a href="/faq#faq5">{{trans('footer.vozmojnosti')}}</a></li>
                            <li><a href="{{route('returnmoney')}}">{{trans('footer.vozvratdeneg')}}</a></li>
                        </ul>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <h4>{{trans('footer.avtoram')}}</h4>
                        <ul>

                            <li><a href="{{route('project.create')}}">{{trans('footer.nachatproekt')}}</a></li>
                            <li><a href="{{route('manual')}}">{{trans('footer.osnoviuspkomp')}}</a></li>
                            <li><a href="{{route('curators')}}">{{trans('footer.investory')}}</a></li>
                        </ul>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <h4>{{trans('footer.dopomoga')}}</h4>
                        <ul>

                            <li><a href="{{route('faq')}}">FAQ</a></li>
                            <li><a href="{{route('rules_service')}}">{{trans('footer.pravilaserv')}}</a></li>
                            {{--<li><a href="#">Задати питання</a></li>--}}
                            <li><a href="{{route('agreement')}}">{{trans('footer.ugodakor')}}</a></li>
                        </ul>
                    </div>
                </div>
                <hr />
                <div class="row footer_contacts">
                    <!--div class="col-md-3 col-sm-6">
                       <a href=""><i class="fa fa-phone"></i><span></span></a>
                    </div>
                    <div class="col-md-3 col-sm-6">
                          <a href="tel:+"><i class="fa fa-phone"></i><span>+</span></a>
                    </div-->
                    <div class="col-md-4 col-sm-6">
                        <a href="mailto:skladchina.ukr@gmail.com"><i class="fa fa-envelope"></i><span>skladchina.ukr@gmail.com</span></a>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <!--a href="tel:+"><i class="fa fa-phone-square"></i><span>+3</span></a-->
                    </div>

                    <div class="footer-mobile menu-footer">
                        <a href="{{route('faq')}}">FAQ</a>
                        <a href="{{route('rules_service')}}">{{trans('footer.pravilaserv')}}</a>
                        <a href="{{route('agreement')}}">{{trans('footer.ugodakor')}}</a>
                    </div>

                    <div class="col-md-4 col-sm-6">
                        <div class="footer_social_wrap">
                            <div class="footer_social">
                                <a href="https://www.facebook.com//" target="_blank"><i class="fa fa-facebook"></i></a>
                            </div>
                            <div class="footer_social">
                                <a href="https://twitter.com/" target="_blank"><i class="fa fa-twitter"></i></a>
                            </div>
                            <div class="footer_social">
                                <a href="https://www.instagram.com//" target="_blank"><i class="fa fa-instagram"></i></a>
                            </div>
                            <div class="footer_social">
                                <a href="https://www.youtube.com/" target="_blank"><i class="fa fa-youtube-play"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
    </div>
</footer>

<script type="text/javascript">
$(function() {
    $(window).scroll(function() {
        if($(this).scrollTop() != 0) {
            $('#toTop').fadeIn();
        } else {
            $('#toTop').fadeOut();
        }
    });
    $('#toTop').click(function() {
        $('body,html').animate({scrollTop:0},800);
    });

});

</script>
