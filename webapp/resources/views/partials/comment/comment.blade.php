<style>
    .comment{
        border: #1a202c;
    }
</style>

<article class="post p-3 mb-3">
    <div style="margin-bottom: 1.5rem;" id="{{$comment->id}}" class="comment d-flex flex-row align-items-center">
            <h6 id="comment:{{$comment->id}}:owner"> <b> {{$comment->owner->username}} </b> says:</h6>
            
            <div class="col-lg-9">
                @if(Auth::id() == $comment->owner_id)
                    <button onclick="editComment({{$comment->id}})" class="col-3 offset-md-3">Edit Comment</button>
                    <button onclick="deleteComment({{$comment->id}})" class="col-3">Delete Comment</button>
                @endif
                <button onclick="report({{$comment->id}},'comment')" class="col-2">report</button>
            </div>

            @php
                if (Auth::check()){
                $positiveVote = Auth::user()->CommentVotes()->where('comment_id','=',$comment->id)->where('is_positive','=',true)->count() > 0;
                $negativeVote = Auth::user()->CommentVotes()->where('comment_id','=',$comment->id)->where('is_positive','=',false)->count() > 0;
            }else{
                $positiveVote = false;
                $negativeVote = false;
            }
            @endphp
    </div>
        <div id="comment:{{$comment->id}}:text" class="comment-text">{{$comment->text}}</div>
        <div id="comment:{{$comment->id}}:edit" class="comment-edit">
            {{--this div is used when editing a commment--}}
        </div>

        <div class="row float-right">
            <button onclick="vote({{$comment->id}},true,'comment')" id="comment:{{$comment->id}}:pvote" class="{{$positiveVote ? 'voted' : ''}} btn thumb-up" style="background-color: #437520"><i class="fa fa-thumbs-up"></i></button>
            <div id="comment:{{$comment->id}}:score" style="margin:0 1.2em 0">{{$comment->total_score}}</div>
            <button onclick="vote({{$comment->id}},false,'comment')" id="comment:{{$comment->id}}:nvote" class="{{$negativeVote ? 'voted' : ''}} btn thumb-down" style="background-color: #70201d"><i class="fa fa-thumbs-down"></i></button>
            <button onclick="comment({{$comment->parent_post}},{{$comment->id}})" class="" style="margin-left: 5em;">reply</button>
        </div>
        <br>

        <div id="post:{{$comment->parent_post}}:comment:{{$comment->id}}:reply" class="new-comment">
            {{-- this div is used to insert the comment box when the client wants to comment on a post--}}
        </div>
</article>
        <div id="post:{{$comment->parent_post}}:comment:{{$comment->id}}:comment-list" class="col" style="margin-left:2em;">
            @foreach($comment->children_comment()->where('owner_id','=',Auth::id())->orderBy('total_score')->get() as $child_comment)
                @include('partials.comment.comment',['comment' => $child_comment])
            @endforeach
            @foreach($comment->children_comment()->where('owner_id','!=',Auth::id())->orderBy('total_score')->get() as $child_comment)
                @include('partials.comment.comment',['comment' => $child_comment])
            @endforeach
        </div>
        <br>

