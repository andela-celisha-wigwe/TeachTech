<div class="col-md-12 comment-block">
    <div class="row">
        <div class="col-md-1 comment-user">
            <img class="video_thumbnail img-responsive" style="width:100%;" src="{{ $comment->user->getAvatar() }}" />
        </div>
        <div class="col-md-10 comment">
            <div class="row">
                <div class="col-md-12 comment-text">
                    <span id="current_comment_{{ $comment->id }}" class="comment_comment">{{$comment->comment}}</span>
                    <form method="POST" action="/comment/{{ $comment->id }}">
                        <input name="_method" type="hidden" value="PATCH">
                        <div id="edit_comment_div{{ $comment->id }}" style="display: none;">
                            @include('comments.error')
                            <input type="text" disabled="disabled" style="display: none;" id="edit_comment_text_{{ $comment->id }}" name="comment" class="edited_comment" value="{{$comment->comment}}" required />
                            <button>Update</button>
                        </div>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    </form>
                </div>
                <div class="col-md-12 comment-info">
                    <i>
                        {{ $comment->user->name }} | {{ $comment->commentedAt() }}

                        <div class="like-model like-comment">
                            @if( Auth::user()->favors($comment) )
                                @include('partials.like_unlike', ['action' => 'unfavorite', 'model' => 'comment', 'id' => $comment->id, 'button' => 'Unlike'])
                            @else
                                @include('partials.like_unlike', ['action' => 'favorite', 'model' => 'comment', 'id' => $comment->id, 'button' => 'Like'])
                            @endif
                        </div>

                    </i>
                </div>
            </div>
        </div>
        @if(Auth::user() && Auth::user()->isCommenter($comment->id))
            <div class="col-md-1 comment-modify">
                <span class="toggle_edit edit_on" id="{{ $comment->id }}" for="{{ $comment->id }}" style="cursor: pointer;">...</span>
                <div class="row menu_buttons" id="menu_for_{{ $comment->id }}" style="display: none; position: absolute;">
                    <div class="col-md-12">
                        <button class="editbutton" for="{{ $comment->id }}" id="edit_for{{ $comment->id }}">Edit</button>
                    </div>
                    <div class="col-md-12">
                        <button class="btn btn-primary deletebutton" for="{{ $comment->id }}" id="deletebutton_for{{ $comment->id }}">Delete</button>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>