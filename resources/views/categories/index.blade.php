@extends('layouts.app')

@section('content')



<div class="panel panel-default">
        <div class="panel-heading">
            CATEGORIES
        </div>
            <div class="row">
                @foreach($categories as $category)
                    <div class="col-md-6 panel-body">
                        <div class="row">
                            <div class="col-md-12 panel panel-heading" align="left">
                                <a href="#{{ $category->id }}" data-toggle="collapse" data-parent="#accordion" href="#{{ $category->id }}" >{{ $category->name }}</a>
                                <button class="add-cat-vid add-video pull-right"><i class="fa fa-plus"></i></button>
                            </div>
                            <div class="col-md-12">
                                <div id="{{ $category->id }}" class="panel-collapse collapse">
                                <!-- <div id="" class=""> -->
                                    @foreach($category->videos as $video)
                                        @include('partials.video_view')
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        <div class="panel-footer"></div>
    </div>
@stop