{{-- на входе $project --}}
<link rel="stylesheet" type="text/css" media="all" href="{{asset('comments/css')}}/comments.css" />
    @include('comments.comments_block', ['essence' => $project])
<script type="text/javascript" src="{{asset('comments/js')}}/comment-reply.js" /></script>
<script type="text/javascript" src="{{asset('comments/js')}}/comment-scripts.js" /></script>
