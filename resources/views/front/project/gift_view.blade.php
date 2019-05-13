{{-- на входе $project, $present вознаграждение или $present=false --}}


@if($present)
<section style="position: relative;">
    @if($present->name)
    <h2 class="reward_header">{{ $present->name }}</h2>
    <hr class="reward_separator" />
    @endif
    @if($present->isImage)
    <img src="{{asset($present->image)}}"/>
    @endif
    <div class="rewards_wrap">
        
        <p>{!! $present->description !!}</p>
        
        <div class="rewards_info">
            <div class="col-md-6 need_sum_reward">{{$present->need_sum}} грн</div>
            <div class="col-md-6 description">
                @if($present->limit && $present->limitOut)
                <div>{{trans('show_project_front.select1')}}:  {{$present->getUserGiftsCount()}}</div>
                @elseif($present->limit)
                <div>{{trans('show_project_front.ostalos')}}:  {{$present->limit - $present->getUserGiftsCount()}} / {{$present->limit}}</div>
                @else
                <div>{{trans('show_project_front.select2')}}:  {{$present->getUserGiftsCount()}}</div>
                @endif

                
            </div>
            <div class="gift-delivery col-md-12">
                @if($present->isDelivery)
                    <h5>{{trans('show_project_front.delivery')}} - {{ $present->delivery_date }}, {{ $present->deliveryMethod }}</h5>
                @endif
            </div>

            @if($project->isActive && !$present->limitOut)
            
                <button class="btn_more reward_hover">{{trans('show_project_front.podderjat')}}</button>
                <div class="clearfix"></div>
            
            @endif

        </div>


        @if($project->isActive && !$present->limitOut)
        <div class="rewards_more">
            <form action="{{route('SC_postCreate')}}" method="post">
                <div class="rewards_more_text">
                    {{csrf_field()}}
                    <input type="hidden" name="project_id" value="{{$project->id}}">
                    <input type="hidden" name="project_gift_id" value="{{$present->id}}">
                    <input type="number" 
                           name="summa" 
                           value='{{ old('summa') }}'
                           placeholder="{{trans('show_project_front.ot')}} {{$present->need_sum}} {{trans('show_project_front.andmore')}}"
                           min="{{$present->need_sum}}" 
                           required
                           style="width: 100%;"
                           >
                </div>
                <button type="submit" class="btn">{{trans('show_project_front.podderjatbtn')}}</button>
            </form>

        </div>
        @endif


    </div>
</section>

@elseif($project->isActive)
<section>
    <div class="rewards_wrap rewards_wrap_fixed">
        <h3>{{trans('show_project_front.anysumm')}}</h3>
        <p>{{trans('show_project_front.withoutpresent')}}</p>
        <form action="{{route('SC_postCreate')}}" method="post" class="_support_project_">
            {{csrf_field()}}
            <input type="hidden" name="project_id" value="{{$project->id}}">
            <input type="number" name="summa" placeholder="{{trans('show_project_front.withoutpresentplaceholder')}}" min="1" required>
            <button type="submit" class="btn">{{trans('show_project_front.podderjat_fixed')}}</button>	
        </form>
    </div>
</section>

<script>
    $(document).ready(function () {
        $("._support_project_ button[type=submit]").on('click', function () {
            $(".rewards_wrap").removeClass("active");
        });

        $(".btn_more").on('click', function () {
            $(".rewards_wrap").removeClass("active");
            $(this).parents('.rewards_wrap').addClass("active").css("transition","0.3s");
            $(this).parents('.rewards_wrap').find('[name=quantity]').keyup();
        });
    });
</script>
@endif
