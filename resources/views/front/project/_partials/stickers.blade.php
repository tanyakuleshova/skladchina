{{-- на входе обхект $project --}}
<div class="stickers">
	@if($project->isClosedSuccess)
	<div class="sticker-successful">
		<div class="sticker-img">
			<img src="{{asset('images/front/sticker_successful.png')}}" />
		</div>
		{{trans('reward.success')}}
	</div>
	@endif

	@if($project->isClosedFail)
	<div class="sticker-ansuccessful">
		<div class="sticker-img">
			<img src="{{asset('images/front/sticker_ansuccessful.png')}}" />
		</div>
		{{trans('reward.nomoney')}}
	</div>
	@endif

	@if($project->isModeration)
	<div class="sticker-under-consideration">
		<div class="sticker-img">
			<img src="{{asset('images/front/sticker_under_consideration.png')}}" />
		</div>
		{{trans('reward.view')}}
	</div>
	@endif

	@if($project->isNotModeration)
	<div class="sticker-under-finalization">
		<div class="sticker-img">
			<img src="{{asset('images/front/sticker_finalization.png')}}" />
		</div>
		{{trans('reward.continue')}}
	</div>
	@endif

</div>