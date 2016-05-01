@extends('layouts.app')

@section('content')
<div class="container">
    @include('partials.add_video_button')
    <div class="row">
        <div class="col-md-3">
            <div class="list-group">
                @foreach($categories as $category)
                    <button type="button" class="list-group-item">
                        <div class="row">
                            <div class="col-md-2"><img src="{{ Auth::user()->getAvatar() }}" style="width: 100%;" alt="..."></div>
                            <div class="col-md-8">{{ substr($category->name, 0, 7) }}</div>
                            <div class="col-md-2 badge">{{ $category->numberOfVideos() }}</div>
                        </div>
                    </button>
                @endforeach
            </div>
        </div>
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="col-md-12">
                    </div>
                </div>
                <div class="panel-body" style="background-color: #2385A1; color: #FFFFFF;">
                    <div class="user-videos">
                        <div class='row'>
                            @foreach($videos as $video)
                                @include('partials.video_view')
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
