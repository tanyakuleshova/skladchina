@extends('admin.layouts.admin-app')
@section('admin_content')
    <div class="col-md-10">
        <div class="ibox float-e-margins user_details">
            <div class="ibox-title">
                <h5>Профиль пользователя {{$user->name}}</h5>
            </div>
            <div>
                <div class="ibox-content no-padding border-left-right">
                        <img alt="image" class="img-circle circle-border m-b-md"
                             src="{{ asset( $user->avatar) }}">
                </div>
                <div class="ibox-content profile-content">
                    <h4><strong>{{ $user->fullName }}</strong></h4>
                    <p><i class="fa fa-map-marker"></i> {{$user->account->city_birth}}</p>
                    <p><i class="fa fa-mobile"></i> {{$user->account->contact_phone}}</p>
                    <h5>
                        О себе :
                    </h5>
                    <p>
                        {{$user->account->about_self}}
                    </p>
                    <!-- <div class="col-md-4"> -->
                        <span class="bar">5,3,9,6,5,9,7,3,5,2</span>
                        <h5><strong>{{$user->projects->count()}}</strong> Проектов</h5>
                    <!-- </div> -->
                    

                    
                    
                    
                    <div class="user-button">
                        <form action="{{route('users.store')}}" method="POST">
                            <input type="hidden" name="id" value="{{ $user->id }}">
                            {{csrf_field()}}
                            <button type="submit" class="btn btn-danger">Войти как пользователь</button>
                        </form>
                        
                        
                        
                        <div class="row">
                            <div class="col-md-2 user_details_btn">
                                <a href="{{redirect()->back()->getTargetUrl()}}" type="button"
                                   class="btn btn-primary btn-md btn-block">Назад</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('admin_script')
    <script src="{{asset('administrator/js/plugins/peity/jquery.peity.min.js')}}"></script>
    <script src="{{asset('administrator/js/demo/peity-demo.js')}}"></script>
@endsection