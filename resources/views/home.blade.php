@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" type="text/css" href="css/user_profile.css">

    <style type="text/css">
         .user-form-field{
            background: none;
            border: none;
            padding: 10px 5px !important;
            font-size: 110%;
            border-radius: 0px;
            width: 100%;
            margin: 0px;
            padding: 0px;
         }
    </style>
@stop

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            $('#update-user').hide();
            $('.user-form-field').attr('readonly', function () {
                return 'readonly';
            });
            $('#edit-user').click( function () {
                $('.user-form-field').prop('readonly', false);
                $('.user-form-field').css({
                        background: '#fff',
                        'border-bottom': 'solid 1px #2385A1'
                });
                $('#update-user').show();
                $(this).hide();
            });

            $('#changeAvatar').click( function () {
                $('#file').trigger('click');
            })

            $("#file").change( function () {
                var reader = new FileReader();
                // console.log(reader);
                // reader.onload();
            });
             
        });

        $('#update-user').click( function (e) {
            // e.preventDefault();
            // userForm = $('#update-user').parents('#user-form');
            // fields = userForm.children('.form-group').children();
            // name = fields.children('#name').val();
            // email = fields.children('#email').val();
            // data = {name:name, email:email};
            // $.post('/user/update', data, function (d) {
            // });
        });

    </script>
@stop



@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-md-offset-0">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="user-avatar">
                                    <img src="{{ Auth::user()->getAvatar() }}" alt="{{ Auth::user()->name }}" class="img-responsive img-thumbnail" style="width: 100%; max-height: 150px; max-width: 150px;">
                                <a href="#" id="changeAvatar" align="center"><span>Change Avatar</span></a>
                                <form class="changeImage" enctype="multipart/form-data" method="POST" action="/user/upload/avatar">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="file" required name="file" id="file" hidden style="display: none">
                                    <button type="submit" name="submit" class="changeAvatarSubmit">Upload</button>
                                    @if ($errors->has('image'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('image') }}</strong>
                                        </span>
                                    @endif
                                </form>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="user-profile-view">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        {{ $user->name }} ({{ $user->email }})
                                    </div>
                                    <div class="panel-body">
                                        <div class="panel panel-info">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    Videos :{{ $user->numberOfVidoes() }}
                                                </div>
                                                <div class="col-md-3">
                                                </div>
                                                <div class="col-md-3">
                                                </div>
                                                <div class="col-md-3">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            @include('partials.add_video_button')
                        </div>
                    </div>
                </div>
                <div class="panel-body" style="background-color: #2385A1; color: #FFFFFF;">
                    <div class="user-videos">
                        <div class='row'>
                            @foreach($user->videos()->get() as $video)
                                @include('partials.video_view')
                            @endforeach
                                <div class='col col-md-3 col-sm-12 col-xs-12' align="center">
                                    <ul class='list-unstyled'>
                                        <li>
                                            <div class="row">
                                                <div class="col-md-12">
                                                        <img src="{!! asset('img/2.jpg') !!}" class="img-responsive img-thumbnail add-video" />
                                                </div>
                                            </div>
                                            <p class='info short'>Add video</p>
                                        </li>
                                    </ul>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
