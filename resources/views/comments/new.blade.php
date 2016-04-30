<div class="col-md-12 comment-block">
    <form  class="form-horizontal" method="POST" action="/comment">
        <div class="row">
            <div class="col-md-1 commenter">
                <img class="video_thumbnail img-responsive" style="width:100%;" src="{{ Auth::user()->getAvatar() }}" />
            </div>
            <div class="col-md-8 write-comment {{ $errors->has('email') ? ' has-error' : '' }}">
                @include('comments.error')
                @include('comments.input_field')
                <input style="width: 100%;" type="number" readonly hidden name="comment_video" value="{{ $video->id }}" />
            </div>
            <div class="col-md-3 post-comment">
                <button type="submit" class="btn btn-primary">POST</button>
            </div>
        </div>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
    </form>
</div>