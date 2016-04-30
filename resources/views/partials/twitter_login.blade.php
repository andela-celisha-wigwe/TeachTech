@extends('layouts.app')

@section('content')
    <div class="panel">
        <div class="panel-header">
            Email for twitter
        </div>
        <div class="panel-body">
            {!! Form::open(['url' => '/twitter/login']); !!}
            <div class="form-group">
                {!! Form::email('twitter_email', null, ['placeholder' => 'Enter your email
                                                     for twitter', 'class' => 'twitter_email']) !!}
                {!! Form::submit('Continue', ['class' => 'btn btn-primary twitter-button']) !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@stop