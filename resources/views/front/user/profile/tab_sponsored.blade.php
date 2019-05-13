@foreach(Auth::user()->getSponsoredProjects() as $project)
    <div class="col-xs-12 col-sm-6 col-md-4">
        @include('front.project.blocks.show_small_project_sponsored',['project'=>$project->load('balance')])
    </div>
@endforeach
