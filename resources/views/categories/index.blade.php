@extends('layouts.app')

@section('content')



<div class="panel panel-default">
        <div class="panel-heading">
            CATEGORIES 
            @if(Auth::user() && Auth::user()->is_admin)
                <a class="btn btn-default add-category" href="category/add" id="add-category-button"><i class="fa fa-plus"></i> New</a>
            @endif
        </div>
        <div class="container">
            <div class="row">
                @foreach($categories as $category)
                  <div class="col-sm-6 col-md-3">
                    <a href="/categories/{{ $category->id }}">
                        <div class="thumbnail">
                            <div class="row">
                                <a href="/categories/{{ $category->id }}">
                                    <div class="col-md-12">
                                        <img src="{{ Auth::user()->getAvatar() }}" style="width: 100%;" class="" alt="...">  
                                    </div>
                                    <div class="col-md-4" style="position: absolute;">
                                        <button class="list-group-item">
                                            <span class="badge">{{ $category->numberOfVideos() }}</span>
                                        </button>
                                    </div>
                                </a>
                            </div>
                          <div class="caption">
                            <a href="/categories/{{ $category->id }}">
                                <h4>{{ $category->name }}</h4>
                            </a>
                          </div>
                        </div>
                    </a>
                  </div>
                @endforeach
            </div>
        </div>
        <div class="panel-footer"></div>
    </div>
@stop