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
                            {!!trans('rulesproject.textrules1')!!}
                            {!!trans('rulesproject.textrules2')!!}
                            
                            <div class="rules_page_infographic">
                                <div class="item item1">
                                    <div class="item_img item_img1">
                                        <img src="{{asset('images/front/regulations_img1.png')}}" alt="">
                                    </div>
                                    <img src="{{asset('images/front/regulations_number1.png')}}" alt="">
                                    {!!trans('rulesproject.textrules2-1')!!}
                                    
                                </div>
                                <div class="item item2">
                                    <div class="item_img item_img2">
                                        <img src="{{asset('images/front/regulations_img2.png')}}" alt="">
                                    </div>
                                    <img src="{{asset('images/front/regulations_number2.png')}}" alt="">
                                    {!!trans('rulesproject.textrules2-2')!!}
                                    
                                </div>
                                <div class="item item3">
                                    <div class="item_img item_img3">
                                        <img src="{{asset('images/front/regulations_img3.png')}}" alt="">
                                    </div>
                                    <img src="{{asset('images/front/regulations_number3.png')}}" alt="">
                                    {!!trans('rulesproject.textrules2-3')!!}
                                    
                                </div>
                                <div class="item item4">
                                    <div class="item_img item_img4">
                                        <img src="{{asset('images/front/regulations_img4.png')}}" alt="">
                                    </div>
                                    <img src="{{asset('images/front/regulations_number4.png')}}" alt="">
                                    {!!trans('rulesproject.textrules2-4')!!}
                                    
                                </div>
                                <div class="item item5">
                                    <div class="item_img item_img5">
                                        <img src="{{asset('images/front/regulations_img5.png')}}" alt="">
                                    </div>
                                    <img src="{{asset('images/front/regulations_number5.png')}}" alt="">
                                    {!!trans('rulesproject.textrules2-5')!!}
                                    
                                </div>
                            </div>
                            <div class="attention"><img src="{{asset('images/front/attention_img.png')}}">
                                {!!trans('rulesproject.textrules2-6')!!}
                                
                            </div>
                        </div>
                        <form action="{{route('project.store')}}" method="post">
                            <div class="check">
                                <span class="icon"></span>
                                {{csrf_field()}}
                                <input type="checkbox" name="confirm_with_rules" class="dvf-target" />
                                {!!trans('rulesproject.textrules2-7')!!}
                                
                            </div>
                            <button class="project_next">Создать проект<img src="{{asset('images/front/create_next_btn.png')}}" height="11" width="7" alt=""></button>
                        </form>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="rules_page_navbar">
                        {!!trans('rulesproject.sidebar')!!}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection