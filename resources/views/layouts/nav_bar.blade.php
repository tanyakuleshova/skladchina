<div class="wrap">
    <!--MENU-->
    <nav id="main-menu">
        <div class="menu-btn">
            <div class="menu-btn-line menu-btn-line-1"></div>
            <div class="menu-btn-line menu-btn-line-2"></div>
            <div class="menu-btn-line menu-btn-line-3"></div>
        </div>
        <div class="moduletable_menu">
            <ul class="nav menu">
                <li><a href="{{route('projects')}}">{{trans('nav_front.projects')}}</a></li>
                <li><a href="{{route('project.create')}}">{{trans('nav_front.start_project')}}</a></li>
                <li><a href="{{route('about')}}">{{trans('footer.whatsdream')}}</a></li>
                <li><a href="{{route('contacts')}}">{{trans('footer.contacts')}}</a></li>
                <!--li><a href="{{route('projects')}}">{{trans('footer.allprojects')}}</a></li-->
                <li><a href="/faq#faq5">{{trans('footer.vozmojnosti')}}</a></li>
                <li><a href="{{route('returnmoney')}}">{{trans('footer.vozvratdeneg')}}</a></li>
                <!--li><a href="{{route('project.create')}}">{{trans('footer.nachatproekt')}}</a></li-->
                <li><a href="{{route('manual')}}">{{trans('footer.osnoviuspkomp')}}</a></li>
                <li><a href="{{route('curators')}}">{{trans('footer.investory')}}</a></li>
            </ul>
            <div class="menu-footer">
                <a href="{{route('faq')}}">{{trans('footer.faq')}}</a>
                <a href="{{route('rules_service')}}">{{trans('footer.pravilaserv')}}</a>
                <a href="{{route('agreement')}}">{{trans('footer.ugodakor')}}</a>
            </div>
        </div>
    </nav>
    <!-- END menu -->

    <nav class="header"> 
        <div class="container">
            <div class="header_left">
                <div class="header_left_top">
                    <form id="search" action="{{ route('projectsearch') }}" method="post">
                        {{ csrf_field() }}
                        <button>
                            <i class="fa fa-search"></i>
                        </button>
                        <input type="text" 
                               name="search" 
                               placeholder="{{trans('nav_front.search')}}" 
                               minlength="3"
                               value="{{ session()->get('search') }}"
                               />
                    </form>
                </div>
                <div class="header_left_bottom hidden-xs hidden-sm">
                    <a class="logo" href="{{ url('/') }}">
                        <img src="{{asset('images/front/DreamstarterBeta.png')}}" alt="Dreamstarter">
                        <!-- {{ config('app.name', 'Dreamstarter') }} -->
                    </a>
                    <ul class="main-menu">
                        <!-- <li><a href="{{route('about')}}">{{trans('nav_front.about')}}</a></li> -->
                        <li><a href="{{route('projects')}}">{{trans('nav_front.projects')}}</a></li>
                        <li><a href="{{route('project.create')}}">{{trans('nav_front.start_project')}}</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="header_right">
                <a class="logo_mobile hidden-lg hidden-md" href="{{ url('/') }}">
                    <img src="{{asset('images/front/DreamstarterBeta.png')}}" alt="Dreamstarter">
                    <!-- {{ config('app.name', 'Dreamstarter') }} -->
                </a>
                <button class='search_toggle'>
                </button>

                <div class="profile">
                    <!-- Right Side Of Navbar -->

                    <!-- Authentication Links -->
                    @if (Auth::guest())
                    <div class="login">
                        <a class="btn btn_nav" href="{{ route('login') }}">
                            <i class="fa fa-user hidden-lg hidden-md"></i>
                            <span class="hidden-sm hidden-xs">{{trans('nav_front.login')}}</span>
                        </a>
                    </div>
                    <!-- <li><a href="{{ route('register') }}">Реестрація</a></li> -->
                    <!--////////////-->
                    @else
                    <div class="dropdown logo_profile">
                        <a  href="#" class="dropdown-toggle" data-toggle="dropdown"
                            role="button" aria-expanded="false">
                            <img src="{{ asset( Auth::user()->avatar) }}" alt="avatar">
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="{{route('myprofile.index')}}">{{trans('nav_front.profile')}}</a>
                            </li>
                            <li>
                                <a href="{{route('mybalance.index')}}">{{trans('nav_front.my_balance')}}</a>
                            </li>
                            <li>
                                <a href="{{route('myprojects.index')}}">{{trans('nav_front.my_project')}}</a>
                            </li>

                            <li>
                                <a class="disabled" style="color: lightgray;">{{trans('nav_front.my_message')}}</a>
                            </li>
                            <li>
                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                    {{trans('nav_front.logout')}}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}"
                                      method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                            <hr>
                            <h4 class="text-center">
                                <p>Баланс:</p> 
                                {{ Auth::user()->getMyBalance() }} &#8372;
                            </h4>
                        </ul>
                    </div>
                    @endif

                </div>


                <!-- Дроп даун с языками -->
                <div class="language">
                    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                    <a rel="alternate" hreflang="{{$localeCode}}"
                       href="{{LaravelLocalization::getLocalizedURL($localeCode) }}">
                        @if($localeCode == 'ru')
                        РУС
                        @else
                        УКР
                        @endif
                    </a>
                    @if($loop->first)
                    <span class="separator">|</span>
                    @endif
                    @endforeach
                </div>

            </div>
        </div>
    </nav>

<script>
    $('.menu-btn').on('click', function () {
        if ($(this).parents('body').is('.opened-menu') !== true) {
            $('body').addClass('opened-menu');
            $('#main-menu').addClass('opened');

        }
        else if ($(this).parents('body').is('.opened-menu') === true) {
            $('body').removeClass('opened-menu');
            $('#main-menu').removeClass('opened');

        }
    });
</script>
