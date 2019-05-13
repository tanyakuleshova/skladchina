<section class="project_main">
    <div class="container">
        <div class="project_main_top">
            <div class="row">
                <div class="col-md-2">
                    <div class="autor">
                        <img src="{{asset($project->author->avatar)}}" width="50" height="50"/>
                        <h4>{{$project->author->name.' '.$project->author->last_name}}</h4>
                        <p>{{trans('show_project_front.projectauthor')}}</p>
                    </div>
                </div>
                <div class="col-md-10">
                    <h3>{{$project->name}}</h3>
                    <div class="description">Цього чекали і продовжують чекати ще з початку 20-го століття - одна з надій майбутнього, яка допоможе нам долати величезні відстані на власному «авіакаре». Найпершим і, природно, невдалим таким авто був «Автоплан».</div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                @if($project->projectVideo)
                @if($project->projectVideo->self_video == 0)
                <iframe width="100%" height="450"
                        src="{{'https://www.youtube.com/embed/'.$project->projectVideo->link_video}}"
                        frameborder="0" allowfullscreen></iframe>
                @else
                <video width="100%" height="450" controls="controls"
                       poster="{{ asset($project->poster) }}">
                    <source src="{{asset('/videos/'.$project->projectVideo->link_video)}}" type='video/mp4'>
                </video>
                @endif
                @else
                <img src="{{ asset($project->poster) }}" class="project-main-img"/>
                @endif
                <div class="project_main_img_text">
                    Тип проекту: <a href="">Універсальний</a>. Проект завершить збір коштів в середу, 12 лютого 2018 о 18:00
                </div>
            </div>
            <div class="col-md-4">
                <div class="project_main_info">
                    <h2>{{ $project->getActualSumm() }}</h2>
                    <p>{{trans('show_project_front.restsumm')}} {{$project->need_sum}} грн</p>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="progress">
                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40"
                                 aria-valuemin="0" aria-valuemax="100" style="width: {{$project->projectProcent()}}%">
                                <span class="sr-only">{{$project->projectProcent()}}% Complete (success)</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-6 col-sm-6 col-md-6 project_main_info">
                    <h3 class="downCountTimer">
                        @if (\Carbon\Carbon::now()>=$project->date_finish)
                        <div class="stickers">
                            <div class="sticker-successful">
                                <div class="sticker-img">
                                    <img src="{{asset('images/front/sticker_successful.png')}}" />
                                </div>
                                Успешный
                            </div>
                            <div class="sticker-ansuccessful">
                                <div class="sticker-img">
                                    <img src="{{asset('images/front/sticker_ansuccessful.png')}}" />
                                </div>
                                Неуспешный
                            </div>
                        </div>
                        @else
                        <span class="hidden">{{ $project->date_finish }}</span>
                        <span class="days"></span> <span>дней</span>
                        @endif
                    </h3>
                    <p>{{trans('show_project_front.projectstart')}}</p>
                    <div class="place">
                        <p>
                            <img src="{{asset('images/front/place.png')}}" width="15" height="15"/>
                            {{ ($project->city && $project->city->cld)?$project->city->cld->name:'' }}
                        </p>
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 project_main_info">
                    <div class="project_main_spons">
                        <h3>{{ $project->getSposoredCount() }}</h3>
                        <p>{{trans('show_project_front.sponsorcount')}}</p>
                    </div>
                    <div class="media">
                        <p>
                            <img src="{{asset('images/front/media.png')}}" width="15" height="15"/>
                            {{ ($project->projectCity && $project->category->cld)?$project->category->cld->name:'' }}
                        </p>
                    </div>
                </div>
                <div class="col-xs-12 project_main_info">
                    <div class="project_main_text">
                        Сподобалася ідея? Щоб підтримати проект можна поділіться посиланням на нього в соціальних мережах, або підтримайте фінансово і станьте одним зi спонсорів.
                    </div>
                    <a href="#vote" class="btn project_main_btn">{{trans('show_project_front.podderjat')}}</a>
                    <div class="sharing">
                        {{trans('show_project_front.share')}}
                        <div class="share42init"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>