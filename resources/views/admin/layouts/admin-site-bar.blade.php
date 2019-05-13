<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <a href="{{ route('admin.dashboard') }}">на главную</a>
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element text-center"> <span>
                    <img alt="image" class="img-circle" src="{{asset(Auth::guard('admin')->user()->avatar)}}"
                    width="50px" height="50px"/>
                </span>
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <span class="clear"><span class="block m-t-xs"><strong
                        class="font-bold">@if(Auth::guard('admin')->check()){{Auth::guard('admin')->user()->name}}@endif</strong>
                    </span> <span class="text-muted text-xs block">Admin<b class="caret"></b></span> </span> </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="#">Профиль</a></li>
                        <li class="divider"></li>
                        <li><a href="{{ route('admin.logout') }}"
                         onclick="event.preventDefault();
                         document.getElementById('logout-form').submit();">
                         Вихід
                     </a>
                     <form id="logout-form" action="{{ route('admin.logout') }}" method="POST"
                     style="display: none;">
                     {{ csrf_field() }}
                 </form>
             </li>
         </ul>
     </div>
     <div class="logo-element">
        MT
    </div>
</li>
<li>
    <a href="#"><i class="fa fa-university" aria-hidden="true"></i><span
        class="nav-label">Проекты</span><span
        class="label label-warning pull-right">{{Auth::guard('admin')->user()->countAllProject()}}</span></a>
        <ul class="nav nav-second-level collapse">
            <li><a href="{{route('a_modprojects.index')}}">На модерации <span class="badge-info">{{Auth::guard('admin')->user()->countModProject()}}</span></a>
            </li>

            <li><a href="{{route('a_allprojects.index')}}">Все проекты</a></li>
            

            <!--li class="hr-line-solid"></li-->
            
        </ul>
    </li>
    @if(Auth::guard('admin')->check() && Auth::guard('admin')->user()->isAdmin && Auth::guard('admin')->user()->countPostProject()) 
        <li>
            <a href="{{route('a_postmodprojects.index')}}"><i class="fa fa-balance-scale" aria-hidden="true"></i> POST MOD <span
        class="label label-danger pull-right">{{ Auth::guard('admin')->user()->countPostProject() }}</span></a>
        </li>
    @endif
    
    <li>
        <a href="{{route('a_updates.index')}}"><i class="fa fa-upload" aria-hidden="true"></i> Обновления</a>
    </li>
    
    @if(Auth::guard('admin')->check() && Auth::guard('admin')->user()->isAdmin)   
    
        <li>
            <a href="#"><i class="fa fa-users"></i> <span class="nav-label">Спонсоры</span></a>
            <ul class="nav nav-second-level collapse">
                <li><a href="{{route('sponsors.index')}}">Список</a></li>
            </ul>
            <ul class="nav nav-second-level collapse">
                <li><a href="{{route('sponsored_statistics.index')}}">По проектам</a></li>
            </ul>
        </li>
    
        <li>
            <a href="{{route('users.index')}}"><i class="fa fa-users"></i> <span class="nav-label">Пользователи </span></a>
        </li>



        <li>
            <a href="#"><i class="fa fa-star"></i> <span class="nav-label">Настройки</span></a>
            <ul class="nav nav-second-level collapse">
                <li><a href="{{route('catgories_project.index')}}">Категории проекта</a></li>
                <li><a href="{{route('status_projects.index')}}">Статусы проекта</a></li>
                <li><a href="{{route('cities.index')}}">Список городов</a></li>
                <li><a href="{{route('balance_type.index')}}">Баланс. Типы.</a></li>
                <li><a href="{{route('balance_status.index')}}">Баланс. Статусы.</a></li>
                <li><a href="{{route('paymethods.index')}}">Платежные методы</a></li>
            </ul>
        </li>
        <li>
            <a href="{{route('a_s_page.index')}}"><i class="fa fa-newspaper-o" aria-hidden="true"></i> Страницы</a>
        </li>

        <li>
            <a href="{{route('balance.index')}}"><i class="fa fa-money" aria-hidden="true"></i> Общий баланс</a>
        </li>

        <li>
            <a href="{{route('a_refund.index')}}"><i class="fa fa-unlock text-danger"></i> Выплаты</a>
        </li>

        <li>
            <a href="{{route('admins.index')}}"><i class="fa fa-bed" aria-hidden="true"></i></i> Администраторы</a>
        </li>
    @endif
</ul>
</div>
</nav>
