<div class="containter" id="new-post">

    <div id="input-new-post-area">
        <div class="form-group">
            <p><input class="form-control" type="text" name="title" id="new-post-title" placeholder="Post Title"></p>
        </div>
        <div class="form-group">
            <p><input class="form-control" id="file" type="file" name="file" /></p>
        </div>
        <div class="form-group">
            <p><input class="form-control" name="text" id="new-post-text" placeholder="Write your post..."></p>
        </div>
        <button id="upload-button" onclick="post({{$event->id}})"> Post </button>
        <div id="post-error">
            {{--this is used to add error when posting--}}
        </div>

    </div>

</div>
