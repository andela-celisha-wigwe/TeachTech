<form  class="form-horizontal" method="POST" action="/{{ $model }}/{{ $id }}/{{ $action }}">
    <button type="submit" class="btn btn-default buttonTo{{ $button }}">{{ $button }}</button>
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
</form>