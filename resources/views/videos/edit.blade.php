@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-0">
            <div class="panel panel-heading">
                <img style="width:100%;" id="{{ $video->id }}" class="video_thumbnail img-responsive" src="http://img.youtube.com/vi/{{ $video->vID() }}/2.jpg" />
            </div>
        </div>
        <div class="col-md-8 col-md-offset-0">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <button type="button" class="close" data-dismiss="panel" aria-hidden="true">&times;</button>
                    <h4 class="panel-title">{{ $video->title }}</h4>
                </div>

                @if ( count($errors) )
                    <div class="alert alert-danger">
                        <ul class="list-unstyled">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div>
                    <form method="POST" action="/video/{{ $video->id }}/update" accept-charset="UTF-8" class="form-horizontal" role="form">
                    <input name="_token" type="hidden" value="{{ csrf_token() }}">
                         <div class="panel-body">
                             <div class="panel-body" style="padding: 10px;">
                                    <div class="form-group">
                                        <label for="title">Title:</label>
                                        <input class="form-control" value="{{ $video->title }}" name="title" type="text" id="title">
                                    </div>
                                    <div class="form-group">
                                        <label for="url">URL:</label>
                                        <input class="form-control" value="{{ $video->url }}" name="url" type="url" id="url"> 
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description:</label>
                                        <textarea class="form-control new-video-description" placeholder="Briefly describe the video" name="description" cols="50" rows="10">
                                            {{ $video->description }}
                                        </textarea>
                                    </div>
                                    <div class="form-group">
                                        <select class="form-control new-video-category" name="category_id">
                                            @foreach(TeachTech\Category::all() as $category)
                                                <option class="edit-video-category" {{ $video->category == $category ? 'selected' : '' }} id="cat-{{ $category->id }}" value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                             </div>
                         </div>
                         <div class="panel-footer">
                            <button type="submit" class="add-video btn-teach-tech">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
