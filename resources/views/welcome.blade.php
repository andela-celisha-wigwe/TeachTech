@extends('layouts.app')

@section('content')
    <div id="home">
        <div class="overlay">
            <div class="row">
                <div class="col-md-8" style="height: 50px;">
                    <div class="panel panel-info" style="background: none;">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="panel-body">
                                    <img src="{!! asset('img/1.jpg') !!}" class="img-responsive img-thumbnail" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="panel-body">
                                    <img src="{!! asset('img/1.jpg') !!}" class="img-responsive img-thumbnail" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                        @if(!Auth::user())
                            @include('partials.login_form')
                        @endif
                </div>
            </div>
        </div>
    </div>
@endsection
