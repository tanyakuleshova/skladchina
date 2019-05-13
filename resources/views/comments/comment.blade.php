@foreach($items as $item)

<li id="li-comment-{{$item->id}}" class="comment">
	<div id="comment-{{$item->id}}" class="comment-container">
            @if($item->project->user_id === auth()->id())
                <form action="{{ route('comment.destroy',$item->id)}}" method="post" class="pull-right delete_comment_form">
                    {{ csrf_field()}}
                    {{ method_field('DELETE') }}
                    <input type="hidden" name="project_id" value="{{ $item->project_id}}">
                    <button type="submit" title="Удалить этот комментарий" class="btn_del_comment"><img src="{{ asset('images/front/create_delete_btn.png') }}" height="12" width="12" alt=""></button>
                </form>
            @endif
            <div class="commentblock">
                <span class="commentheader">
                    <img alt="" src="{{ asset($item->user->avatar) }}" class="avatar" />
                    <span class="comentorname">{{$item->user->name}}</span>
                    <span class="comentsdate">{{ is_object($item->created_at) ? $item->created_at->format('d.m.Y в H:i') : ''}}</span>
                </span>
                <span class="commentbody">
                    <p class="comment-content">{{ $item->text }}</p>
                    <p class="replycomment">
                        <a class="comment-reply-link btn" href="#respond" onclick="return addComment.moveForm(&quot;comment-{{$item->id}}&quot;, &quot;{{$item->id}}&quot;, &quot;respond&quot;, &quot;{{$item->article_id}}&quot;)">{{trans('show_project_front.reply')}}</a>
                    </p>
                </span>
            </div>
	</div>
	@if(isset($com[$item->id]))
	<ul class="children">
		@include('comments.comment', ['items' => $com[$item->id]])
	</ul>
	@endif
</li>

@endforeach