{{--  На входе номер текущего шага $nstep & $project  --}}
<!-- Nav tabs -->
<div class="container">
<div class="row">
<div class="col-md-12">
    
<ul class="nav nav-tabs nav-justified js_steps_navigation" role="tablist">
        @if($nstep == 1)
            <li role="presentation" class="active"><a aria-controls="home" role="tab"  data-step="1" title="1"><span>{{trans('createproject.main')}}</span></a></li>
        @else
            <li role="presentation" ><a href="{{ route('edit_project',['id'=>$project->id,'step'=>1]) }}"  data-step="1" aria-controls="home" role="tab" title="1"><span>{{trans('createproject.main')}}</span></a></li>
        @endif
        
        
        @if($nstep == 2)
            <li role="presentation" class="active"><a aria-controls="inform" role="tab"  data-step="2" title="2"><span>{{trans('createproject.info')}}</span></a></li>
        @else
            <li role="presentation"><a href="{{ route('edit_project',['id'=>$project->id,'step'=>2]) }}"  data-step="2" aria-controls="inform" role="tab" title="2"><span>{{trans('createproject.info')}}</span></a></li>
        @endif

        
        @if($nstep == 3)
            <li role="presentation" class="active"><a aria-controls="presents" role="tab" data-step="3" title="3"><span>{{trans('createproject.present')}}</span></a></li>
        @else
            <li role="presentation"><a href="{{ route('edit_project',['id'=>$project->id,'step'=>3]) }}"  data-step="3" aria-controls="presents" role="tab" title="3"><span>{{trans('createproject.present')}}</span></a></li>
        @endif
        

        @if($nstep == 4)
            <li role="presentation" class="active"><a aria-controls="about" role="tab" data-step="4" title="4"><span>{{trans('createproject.about')}}</span></a></li>
        @else
            <li role="presentation"><a href="{{ route('edit_project',['id'=>$project->id,'step'=>4]) }}" data-step="4" aria-controls="about" role="tab" title="4"><span>{{trans('createproject.about')}}</span></a></li>
        @endif
        

        @if($nstep == 5)
            <li role="presentation" class="active"><a aria-controls="score" role="tab" data-step="5" title="5"><span>{{trans('createproject.bill')}}</span></a></li>
        @else
            <li role="presentation"><a href="{{ route('edit_project',['id'=>$project->id,'step'=>5]) }}" data-step="5" aria-controls="score" role="tab" title="5"><span>{{trans('createproject.bill')}}</span></a></li>
        @endif
        
        
        @if($nstep == 6)
            <li role="presentation" class="active"><a aria-controls="modern" role="tab" data-step="6" title="6"><span>{{trans('createproject.moderation')}}</span></a></li>
        @else
            <li role="presentation"><a href="{{ route('edit_project',['id'=>$project->id,'step'=>6]) }}" data-step="6" aria-controls="modern" role="tab" title="6"><span>{{trans('createproject.moderation')}}</span></a></li>
        @endif
</ul>
<script>
    $(document).ready(function () {
        var listValid = {{ $project->valid_steps?json_encode($project->valid_steps):'[]' }};
        if (listValid.length) {
            $('.js_steps_navigation li a').each(function(){
                    if (jQuery.inArray( $(this).data('step'), listValid )>-1){
                        $(this).parent('li').addClass('bg-success');
                    }
                  });
        }
        
        var current_step_focus  = false;
        $(document).on('focus','input,textarea,div[contenteditable="true"]', function(e) {
           current_step_focus = true; 
        });

        $('.js_steps_navigation li a').on('click', function(e){
           e.preventDefault();
           if(current_step_focus) {
               checkButtonSwalLink(this,'warning','Внесённые изменения могут не сохраниться','Перейти','Отменить переход');
           } else {
                window.location.href = this.href;
           }
        });

        

        
        
    });
</script>
</div>
</div>
</div>
<!-- End Nav tabs -->