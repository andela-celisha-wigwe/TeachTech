@extends('layouts.app')

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {

            $('.toggle_edit').click( function () {
                id = $(this).attr('for');
                $('.menu_buttons#menu_for_' + id).toggle();
            });


            $('.deletebutton').click(function () {
                id = $(this).attr('for');
                token = "{{ csrf_token() }}";
                data = {id:id, _token:token};
                $.ajax({
                    url:'/comment/delete',
                    type: 'DELETE',
                    data: data,
                    success: function (d) {
                        location.reload();
                    }
                });
            });


            $('.editbutton').click(function () {
                id = $(this).attr('for');
                $('#current_comment_' + id).toggle();
                $('#edit_comment_div' + id).toggle();
                $('#edit_comment_text_' + id).toggle();
                $('#edit_comment_text_' + id).removeAttr('disabled');
            });

            // $('.edit_on').click(function () {
            //     id = $(this).attr('for');
            //     $('.edit_on#' + id).removeClass('edit_on').addClass('edit_off').html("&times;");
            // });

            // $('.edit_off').click(function () {
            //     id = $(this).attr('for');
            //     console.log(id);
            //     $('.edit_off#' + id).removeClass('edit_off').addClass('edit_on').html("...");
            //     // $('.edit_off#' + id).removeClass('edit_off').addClass('edit_on').html("...");
            // });
        });
    </script>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12" style="background-color: #2385A1; color: #FFFFFF;">
                                    <iframe width="100%" height="400" src="{{ $video->srcFrame() }}?autoplay=0" frameborder="0" allowfullscreen ></iframe>
                            </div>
                            <div class="col-md-12 panel">
                                <h3 class="video-title">{{ $video->title }}</h3>
                                <h4 class="video-user">{{ $video->user->name }}</h4>
                                <hr />
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    @if(Auth::user())
                                        <div class="col-md-12 like-model like-video">
                                            @if( Auth::user()->favors($video) )
                                                @include('partials.like_unlike', ['action' => 'unfavorite', 'model' => 'video', 'id' => $video->id, 'button' => 'Unlike'])
                                            @else
                                                @include('partials.like_unlike', ['action' => 'favorite', 'model' => 'video', 'id' => $video->id, 'button' => 'Like'])
                                            @endif
                                        </div>
                                        @include('comments.new')
                                    @else
                                        <button class="loginButton">Login</button> to post comment.
                                    @endif

                                    @if (count($comments) > 0)
                                        @foreach($comments as $comment)
                                            @include('comments.index')
                                        @endforeach
                                        <div class="col-md-12 pull-right">
                                            {!! $comments->render() !!}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-body" style="background-color: #2385A1; color: #FFFFFF;">
                        @foreach(TeachTech\Video::all() as $video)
                            <a href="/video/{{ $video->id }}">
                                <div class="row">
                                     <div class="col-md-4 related-videos">
                                        <img style="width:100%; height:100%;" id="{{ $video->id }}" class="video_thumbnail img-responsive" src="http://img.youtube.com/vi/{{ $video->vID() }}/2.jpg" />
                                     </div>
                                     <div class="col-md-8 related-videos">
                                        <div class="row">
                                            <div class="col-md-12">
                                                {{ $video->shortTitle() }}
                                            </div>
                                        </div>
                                     </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop