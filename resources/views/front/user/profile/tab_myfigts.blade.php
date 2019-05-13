@foreach(Auth::user()->gifts as $gift)
    <div class="col-xs-12 col-md-4">
        <a href="{{ route('project.show', $gift->project->id) }}" class="rewards">
            <section>
                <img src="{{asset($gift->gift->image)}}"/> 
                <div class="rewards_wrap">
                    {!!$gift->gift->description!!}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="rewards_statistic">цена: {{$gift->gift->need_sum}} грн</div>
                            <div class="rewards_statistic">выбрано : {{ $gift->quantity }}</div>
                            <div class="rewards_statistic">сумма : {{ $gift->order?$gift->order->summa:'' }}</div>
                            <div class="rewards_statistic">{{trans('user_profile.reciveprestnt')}}: {{$gift->gift->delivery_date}}</div>
                            <div class="rewards_statistic">доставка: {{ $gift->gift->delivery->name }}</div>
                        </div>
                    </div>
                </div>
            </section>
        </a>
    </div>
@endforeach