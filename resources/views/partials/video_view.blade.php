<div class='col col-md-3 col-sm-6 col-xs-12' align="center">
    <ul class='list-unstyled'>
        <li>
            <div class="row">
                <div class="col-md-12" id="{{ $video->id }}">
                    <a href="video/{{ $video->id }}">
                        <img style="width:100%; height:50%;" id="{{ $video->id }}" class="video_thumbnail img-responsive" src="http://img.youtube.com/vi/{{ $video->vID() }}/2.jpg" />
                    </a>
                </div>
                    @if(Auth::user())
                        @if(Auth::user()->isOwner($video->id))
                            <!-- <div class="row video-manager">
                                <div class="col-md-4 manager-edit"><i class="fa fa-pencil"></i></div>
                                <form action="video/{{$video->id}}">
                                    <input name="_method" type="hidden" value="DELETE">
                                    <input type="text" hidden value="{{csrf_token()}}" />
                                    <button type="submit" class="col-md-4 manager-delete" style="background:none; color: #fff;"><i class="fa fa-trash"></i></button>
                                </form>
                                <div class="col-md-4 manager-favorite"><i class="fa fa-heart"></i></div>
                            </div> -->
                        @endif
                    @endif
            </div>
        </li>
    </ul>
</div>