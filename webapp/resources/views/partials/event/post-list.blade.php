@if (@count($content) > 0)


    @foreach($content as $post)
    <article class="question-preview card flex-row align-items-center">
        <h1>Post</h1>
        <div>ID:{{$post['post']->id}}</div>
        <div class="counts">
            <div>{{$post['post']->score}} votes</div>
            <button onclick="vote({{$post['post']->id}},true,'post')">upvote</button>
            <button onclick="vote({{$post['post']->id}},false,'post')">downvote</button>
        </div>

        <div class="post-body">
            <header class="post-header">

                <div class="post-header d-flex align-items-center">
                    <!-- Post Title -->
                    <h4 class="post-title flex-grow-1"> {{$post['post']->name}}</h4>
                    <!-- Post date -->
                    <div class="post-details d-flex">
                     <p>{{$post['post']->date}}</p>
                    </div>
                </div>
            </header>
            <div class="limited-text-3 md-remove" id="P{{$post['post']->id}}T">
                <p>{{ $post['post']->text }}</p>
            </div>
            <div class="post-image">
                <img src={{$post['post']->file}} alt="">
            </div>
            <div id="P{{$post['post']->id}}C">
                @if(count($post['comments']) > 0)
                    @foreach($post['comments'] as $comment)
                        @include('partials.common.event.comment-list',['comment'=>$comment])
                    @endforeach
                @endif
            </div>
        </div>
    </article>
    @endforeach
@else
    <p>No posts to show.</p>
@endif
