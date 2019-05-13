@foreach($projects as $project)
        @include('front.project.blocks.show_small_project_standart',['project'=>$project->load('balance')])
@endforeach
