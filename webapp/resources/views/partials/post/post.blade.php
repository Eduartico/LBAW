<article class="post p-3 mb-3">
    <div style="margin-bottom: 1.5rem;" class="d-flex flex-row align-items-center">
          @if(is_null($post->owner->username))
              <h6> <b> SUSPENDED USER </b> says <h6>
          @else
              <h6> <b> {{$post->owner->username}} </b> says: </h6>
          @endif


        <div class="col-lg-9 justify-content-between">
        @if($post->owner_id == Auth::id())
            <button class="col-md-2 offset-lg-6">Edit Post</button>
            <button class="col-sm-3">Delete Post</button>
        @else
            <button class="col-sm-2" onclick="report({{$post->id}},'post')">report</button>
        @endif
        </div>
    </div>
    <p class="comment-body" id={{$post->id}}>{{$post->text}}</p>

    @if($post->file != null)
        <p><img src="{{asset('storage/'.$post->file)}}" width="200px"></p>
    @endif
    @php
        if (Auth::check()){
            $positiveVote = Auth::user()->PostVotes()->where('post_id','=',$post->id)->where('is_positive','=',true)->count() > 0;
            $negativeVote = Auth::user()->PostVotes()->where('post_id','=',$post->id)->where('is_positive','=',false)->count() > 0;
        }else{
            $positiveVote = false;
            $negativeVote = false;
        }
    @endphp
    <div class="row float-right">
        <button onclick="vote({{$post->id}},true,'post')" id="post:{{$post->id}}:pvote" class="{{$positiveVote ? 'voted' : ''}} btn thumb-up" style="background-color: #437520"><i class="fa fa-thumbs-up"></i></button>
        <div id="post:{{$post->id}}:score" style="margin:0 1.2em 0">{{$post->score}}</div>
        <button onclick="vote({{$post->id}},false,'post')" id="post:{{$post->id}}:nvote" class="{{$negativeVote ? 'voted' : ''}} btn thumb-down" style="background-color: #70201d"><i class="fa fa-thumbs-down"></i></button>
        <button onclick="comment({{$post->id}},null)" class="" style="margin-left: 5em;">reply</button>
    </div>
    <br>

    <div id="post:{{$post->id}}:reply" class="new-comment">
        {{-- this div is used to insert the comment box when the client wants to comment on a post--}}
    </div>

</article>
    <div id="post:{{$post->id}}:comment-list" class="col" style="margin-left:2em;">
        @if(count ($post->comments()->whereNull('parent_comment')->get()) > 0)
            @foreach($post->comments()->whereNull('parent_comment')->where('owner_id','=',Auth::id())->orderBy('total_score')->get() as $comment)
                @include('partials.comment.comment',$comment)
            @endforeach
            @foreach($post->comments()->whereNull('parent_comment')->where('owner_id','!=',Auth::id())->orderBy('total_score')->get() as $comment)
                @include('partials.comment.comment',$comment)
            @endforeach
        @else
            <p id="warning-nocomment" class="text-center"> There are no comments! :( </p>
        @endif
    </div>
<hr>


