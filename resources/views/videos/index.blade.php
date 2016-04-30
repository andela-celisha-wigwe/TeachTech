@extends('layouts.app')

@section('content')
<div class="container">
    @include('partials.add_video_button')
    <div class="row">
        <div class="col-md-12">
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
