@extends('layouts.app')

@section('content')
	<div class="panel panel-default">
		<div class="panel panel-heading">
			Add Category
		</div>

		<form method="POST" action="/category/add" class="form-horizontal" role="form">
			<label for="name" class="">Name:</label>
			<input type="text" id="name" name="name" maxlength="15" value="{{ old('name') }}" required class="form-control" />
			<label for="brief" class="">Brief</label>
			<textarea id="brief" name="brief" placeholder="Enter a brief description of the category" maxlength="255" class="form-control" required>{{ old('brief') }}</textarea>
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<button type="submit" class="btn btn-default">Add</button>
			<hr />
		</form>
	</div>
@endsection