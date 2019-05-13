<section class="project_gifts">
        <h3 class="text-center m">
            Подарки проекта {{$project->name}}
        </h3>
        <div class="col-md-12">
            @foreach($project->projectGifts as $gift)

            <div class="wrap">
                <img src="{{asset($gift->image)}}" width="250" height="250" />

                <div class="rewards_info">
                    <div class="description">
                        <h4 class="about">{!!$gift->description!!}</h4>
                        <div class="font-bold">Минимальная сумма: {{$gift->need_sum}} грн.</div>
                        <div class="font-bold">{{trans('createproject.limitpresent')}}: {{$gift->limit}}</div>
                        <div class="font-bold">{{trans('createproject.dateapresent')}}: {{$gift->delivery_date}}</div>
                        <div class="font-bold">Доставка: {{$gift->delivery?$gift->delivery->name:''}}</div>
                        <div class="font-bold">Вопрос: {{$gift->question_user}}</div>
                    </div>
                </div>

            </div>

            @endforeach
        </div>
</section>