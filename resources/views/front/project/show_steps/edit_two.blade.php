@extends('layouts.app')
@section('title','Информация')
@section('style')
<link href="{{asset('administrator/css/plugins/summernote/summernote.css')}}" rel="stylesheet">
<link href="{{asset('administrator/css/plugins/summernote/summernote-bs3.css')}}" rel="stylesheet">
@endsection
@section('content')
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                {!!trans('createproject.headerzag')!!}
            </div>
        </div>
    </div>
</section>
<section class="create_tabs">
    <div class="wide-border">
        @include('front.project.show_steps.navigation_steps',['nstep'=>2,'project'=>$project])
    </div>
    <div class="container">
        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="tab2">
                <div class="row">
                    <main>
                        <div class="col-md-8">                        
                            <article id="article">
                                <div class="create_project create_info">
                                    <div class="create-project-video">
                                        @if($project->projectVideo)
                                            @if($project->projectVideo->self_video == 0)
                                                <iframe width="100%" height="350"
                                                src="{{'https://www.youtube.com/embed/'.$project->projectVideo->link }}" frameborder="0" allowfullscreen></iframe>
                                            @else
                                                <video width="100%" height="350" controls="controls" poster="{{ asset($project->poster) }}">
                                                    <source src="{{ asset($project->projectVideo->link) }}" type='video/mp4'>
                                                </video>
                                            @endif
                                            <form action="{{route('delete_project_video',$project->projectVideo->id)}}"
                                              method="get">
                                                {{csrf_field()}}
                                                <button type="submit" class="btn">{{trans('createproject.delete')}}</button>
                                            </form>
                                        @endif
                                    </div>
                            
                                    <form action="{{route('update_project',['id'=>$project->id,'step'=>2])}}" 
                                          id="js_for_to_send_to_7234"
                                          method="post" 
                                          enctype="multipart/form-data">
                                        {{csrf_field()}}
                                        {{ method_field('PUT') }}
                                        
                                        @if(!$project->projectVideo)
                                        <label class="top_reset">{{trans('createproject.upvideo')}}</label>
                                        <input type="text" name="video_iframe" placeholder="https://">
                                        <h4>{!!trans('createproject.videolink')!!}</h4>
                                        <label>{{trans('createproject.upounvideo')}}</label>
                                        <h4>{{trans('createproject.upounvideodesc')}}</h4>
                                        <div class="media_profile">
                                            <a href="#"><img src="{{asset('images/front/add_video.png')}}" alt=""></a>
                                            <div class="media_profile_info">
                                                <input type="file" name="video_user" placeholder="https://">
                                                {!!trans('createproject.paramvideo')!!}
                                            </div>
                                        </div>
                                        @endif
                                        <h4>{!!trans('createproject.zagproject')!!}</h4>
                                        <label>{{trans('createproject.describeproject')}}</label>
                                        <textarea name="description" class="summernote">{{$project->description}}</textarea>
                                        <h4>{!!trans('createproject.describeprojectdet')!!}</h4>
                                        <!-- Реализовать форму редактирование сохраненных проектов -->
                                        
                                    </form>
                                </div>
                            </article>
                        </div>
                        <div class="col-md-4">
                            <div class="create_section_rules">
                                <div class="description">
                                    {!!trans('createproject.rulesidefirststep')!!}
                                </div>
                            </div>
                            <aside id="aside1">
                                <div class="buttons_project buttons_project_fixed">
                                    <button class="btn project_save"
                                            onclick="$('#js_for_to_send_to_7234').submit();"
                                          >{{trans('createproject.saveprojectdet')}}<!-- <i class="fa fa-chevron-right"></i> --></button>
                                </div>
                            </aside>
                        </div>
                    </main>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
@section('script')
<script src="{{asset('administrator/js/plugins/summernote/summernote.min.js')}}"></script>
<script>
    $(document).ready(function () {
        $('.summernote').summernote({
  height: 500,                 // set editor height
  minHeight: null,             // set minimum height of editor
  maxHeight: null,             // set maximum height of editor
  maxTextLength: 0,
});
    });
</script>
<script>
(function(){
var a = document.querySelector('#aside1'), b = null, P = 0;
window.addEventListener('scroll', Ascroll, false);
document.body.addEventListener('scroll', Ascroll, false);
function Ascroll() {
  if (b == null) {
    var Sa = getComputedStyle(a, ''), s = '';
    for (var i = 0; i < Sa.length; i++) {
      if (Sa[i].indexOf('overflow') == 0 || Sa[i].indexOf('padding') == 0 || Sa[i].indexOf('border') == 0 || Sa[i].indexOf('outline') == 0 || Sa[i].indexOf('box-shadow') == 0 || Sa[i].indexOf('background') == 0) {
        s += Sa[i] + ': ' +Sa.getPropertyValue(Sa[i]) + '; '
      }
    }
    b = document.createElement('div');
    b.style.cssText = s + ' box-sizing: border-box; width: ' + a.offsetWidth + 'px;';
    a.insertBefore(b, a.firstChild);
    var l = a.childNodes.length;
    for (var i = 1; i < l; i++) {
      b.appendChild(a.childNodes[1]);
    }
    a.style.height = b.getBoundingClientRect().height + 'px';
    a.style.padding = '0';
    a.style.border = '0';
  }
  var Ra = a.getBoundingClientRect(),
      R = Math.round(Ra.top + b.getBoundingClientRect().height - document.querySelector('#article').getBoundingClientRect().bottom);  // селектор блока, при достижении нижнего края которого нужно открепить прилипающий элемент
  if ((Ra.top - P) <= 0) {
    if ((Ra.top - P) <= R) {
      b.className = 'stop';
      b.style.top = - R +'px';
    } else {
      b.className = 'sticky';
      b.style.top = P + 'px';
    }
  } else {
    b.className = '';
    b.style.top = '';
  }
  window.addEventListener('resize', function() {
    a.children[0].style.width = getComputedStyle(a, '').width
  }, false);
}
})()
</script>
@endsection
