<form class="form-horizontal" id="user-form" role="form" method="POST" action="{{ url('/user/update') }}">
    {!! csrf_field() !!}
    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
        <div class="col-md-5">
            <input type="text" class="user-form-field" id="name" name="name" value="{{ $user->name }}">
            @if ($errors->has('name'))
                <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>
        <div class="col-md-4">
            <input type="email" class="user-form-field" id="email" name="email" value="{{ $user->email }}">
            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
        <div class="col-md-3">
            <button type="button" class="btn-primary add-video edit-profile-button pull-right" id="edit-user">Edit Profile</button>
            <button type="sumit" class="add-video edit-profile-button pull-right" id="update-user">Update</button>
        </div>
    </div>
</form>
