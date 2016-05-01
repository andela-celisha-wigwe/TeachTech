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
                    {!! Form::open(['url' => 'video/' . $video->id . '/update', 'class' => 'form-horizontal', 'role' => 'form']) !!}
                         <div class="panel-body">
                             <div class="panel-body" style="padding: 10px;">
                                    <div class="form-group">
                                        {!! Form::label('title', 'Title:') !!}
                                        {!! Form::text('title', $video->title, ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('url', 'URL:') !!}
                                        {!! Form::url('url', $video->url, ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('title', 'Description:') !!}
                                        {!! Form::textarea('description', $video->description, ['class' => 'form-control new-video-description', 'placeholder' => 'Briefly describe the video']) !!}
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
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
