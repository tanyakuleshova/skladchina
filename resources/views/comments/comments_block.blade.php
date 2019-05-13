@php

	if($essence){
		$comments = $essence->comments;

		/*
		 * Группируем комментарии по полю parent_id. При этом данное поле становится ключами массива 
		 * коллекций содержащих модели комментариев
		 */
		$com = $comments->where('status', 1)->groupBy('parent_id');
	} else $com = null;

@endphp


<!--Блок для вывода сообщения про отправку комментария-->
<div class="wrap_result"></div>


<div id="comments">
    @if(!$essence->comments()->count())
        <p>{{trans('show_project_front.addfirstcomment')}}</p>
    @endif
    

    <ol class="commentlist group">
            @if($com)
                @foreach($com as $k => $comments)
                        <!--Выводим только родительские комментарии parent_id = 0-->

                        @if($k)
                                @break
                        @endif

                        @include('comments.comment', ['items' => $comments])

                @endforeach                
            @endif
    </ol>



    <div id="respond">
            <h3 id="reply-title"> {{trans('show_project_front.addcomment')}}</h3><p><a rel="nofollow" id="cancel-comment-reply-link" href="#respond" style="display:none; float: right;">{{trans('show_project_front.cancelcomment')}}</a></p>
            <!--параметр action используется ajax-->
            <form action="{{ route('comment.store')}}" method="post" id="commentform">
                    <p class="comment-form-comment"><label for="comment">{{--trans('blog.yourcomment')--}}</label>
                        <textarea class="form-control" id="comment" name="text" cols="45" rows="4" ></textarea>
                    </p>

                    <!--Данные поля так же нужны для работы JS - вставки формы сразу за комментарием на который нужно ответить--> 
                    <input type="hidden" id="comment_blog_ID" name="comment_project_ID" value="{{ $essence->id}}">
                    <input type="hidden" id="comment_parent" name="comment_parent" value="">

                    {{ csrf_field()}}

                    <div class="clear"></div>
                    <p class="form-submit">
                        <input class="btn btn-blue" name="submit" type="submit" id="submit" value="{{trans('show_project_front.sendcomment')}}" />
                    </p>
            </form>
    </div>
	
</div>