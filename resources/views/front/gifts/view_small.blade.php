@if (isset($add) && $add) 
    <div class='aj_gift_small' data-id='{{$gift->id}}' data-project_id='{{$gift->project_id}}'>
@endif

<section>
    @if($gift->name)
        <div class="rewards_wrap"><h3>{{ $gift->name }}</h3></div>  
    @endif
    @if($gift->isImage)
        <img src="{{asset($gift->image)}}"/>
    @endif
    <div class="rewards_wrap">
        <h3>{{$gift->need_sum}} грн</h3>
        {!!$gift->description!!}
        <div class="row">
            <div class="rewards_info">
                <div class="description">
                    @if($gift->limit)
                        <span>{{trans('createproject.limitpresent')}}: {{$gift->limit}}</span>
                    @else
                        <span></span>
                    @endif
                    
                    @if($gift->isDelivery)
                    <span>{{trans('createproject.dateapresent')}}: {{ $gift->duration?:'---' }}</span>
                    @endif
                </div>
            </div>
            <div class="rewards_support">
                <button class="btn edit_gift_btn pull-right" title="{{trans('createproject.changepres')}}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                <button class="btn btn-danger delete_gift_btn pull-right" title="{{trans('createproject.delete')}}"><i class="fa fa-trash" aria-hidden="true"></i></button>
            </div>
        </div>
    </div>
</section>
@if (isset($add) && $add) 
    </div>
@endif