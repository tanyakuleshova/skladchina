<li id="li-comment-{{$data['id']}}" class="comment">
    <div id="comment-{{$data['id']}}" class="comment-container new_comment">
        <div class="commentblock">
            <span class="commentheader">
                <img alt="" src="{{ asset($data['avatar']) }}" class="avatar" />
                <span class="comentorname">{{$data['name']}}</span>
                <span class="comentsdate">{{trans('show_project_front.lasttimecomment')}}</span>
            </span>
            <span class="commentbody">
                <p class="comment-content">{{ $data['text'] }}</p>
            </span>
        </div>
    </div>
</li>