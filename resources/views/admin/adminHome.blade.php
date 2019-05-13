@extends('admin.layouts.admin-app')
@section('admin_content')
@if(Auth::guard('admin')->check() && Auth::guard('admin')->user()->isAdmin)  
    <div class="wrapper wrapper-content admin_home">
        <div class="row">
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <a href="{{route('a_allprojects.index')}}"><span class="label label-info pull-right">Перейти</span></a>
                        <h5>Проектов</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">{{$projects_count}}</h1>
                        <div class="stat-percent font-bold text-info"><i class="fa fa-dropbox fa-2x"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <a href="{{route('users.index')}}"><span class="label label-danger pull-right">Перейти</span></a>
                        <h5>Пользователей</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">{{$users_count}}</h1>
                        <div class="stat-percent font-bold text-danger"><i class="fa fa-user fa-2x"></i></div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <a href="{{route('a_updates.index')}}"><span class="label label-warning pull-right">Перейти</span></a>
                        <h5>Обновления</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">{{ $updates->get('new_u') }} / <span style="color: gainsboro;">{{ $updates->get('all_u') }}</span></h1>
                        <div class="stat-percent font-bold text-warning"><i class="fa fa-upload fa-2x" aria-hidden="true"></i></div>
                    </div>
                </div>
            </div>
            
        </div>
        
        <div class="row">
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <a href="{{route('a_refund.index')}}"><span class="label label-danger pull-right">Перейти</span></a>
                        <h5>Выплаты</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">{{ $refund->get('new_r') }} / <span style="color: gainsboro;">{{ $refund->get('all_r') }}</span></h1>
                        <div class="stat-percent font-bold text-danger"><i class="fa fa-unlock fa-2x text-danger"></i></div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
@endif
@endsection