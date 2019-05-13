{{-- на входе $project --}}
<div class="row">
    <section class="timeline">
        @foreach($project->pupdates()->approved()->get() as $upd)

        <article class="item">
            <div class="align">
                <div class="date">{{ $upd->created_at}}</div>
                <header>{{ strip_tags($upd->shotDesc) }}</header>
                @if($upd->image)
                <img src="{{asset($upd->image)}}" 
                     class="img-responsive center-block">
                @endif
                <div class="description">
                    {!! $upd->text  !!}
                </div>
            </div>
        </article>

        @endforeach
    </section>
</div>