{{-- на входе $project --}}
@if($project->getSponsored()->count())
    @foreach($project->getSponsored() as $usponsor)
    <div class="col-md-4">
        <div class="spons_wrap">
            <div class="spons_img">
                <img src="{{asset($usponsor->avatar)}}"  alt="avatar">
            </div>
            <div class="spons_name">{{ $usponsor->name }}</div>
            <div class="spons_name spons_name_text">Количество поддержаных проектов <span class="spons_project">{{ $usponsor->getSponsoredProjects()->count() }}</span></div>
        </div>
    </div>
    @endforeach
@elseif($project->isClosedFail && $project->getFailOrderSponsoredCount())
    @foreach($project->getFailOrderSponsored() as $sp_ord)
    <div class="col-md-4">
        <div class="spons_wrap">
            <div class="spons_img">
                <img src="{{asset($sp_ord->user->avatar)}}"  alt="avatar">
            </div>
            <div class="spons_name">{{ $sp_ord->user->name }}</div>
        </div>
    </div>
    @endforeach
@else
<!-- У проекта ещё нет споносров, будьте первым -->
@endif