<div>
    <h2>Comment</h2>
    <div>Id:{{$comment['content']->id}}</div>
    <div>{{$comment['content']->total_score}}</div>
    <div>{{$comment['content']->text}}</div>
    <div>{{$comment['username']}}</div>
    <div>
        @foreach($comment['comments'] as $c)
            @include('partials.common.event.comment-list',['comment'=>$c])
        @endforeach
    </div>
    <a onclick="getChildComment({{$comment['content']->id}})">load more comments</a>
</div>
