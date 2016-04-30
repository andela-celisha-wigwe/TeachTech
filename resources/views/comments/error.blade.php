@if ($errors->has('comment'))
    <span class="help-block">
        <strong>{{ $errors->first('comment') }}</strong>
    </span>
@endif