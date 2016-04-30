@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
        </div>
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-8">
                            @include('partials.login_form')
                        </div>
                        <div class="col-md-4">
                            @include('auth.social_login')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
