@extends('layout')

@section('content')

<div class="row col-md-8 col-md-offset-2">
	<h1>Create new project</h1>
	<form role="form" action="/project/store" method="POST">
		{{ csrf_field() }}
		  <div class="form-group">
		    <label for="name">Project Name</label>
		    <input type="name" class="form-control" id="name" placeholder="Enter name" value="{{ old('name') }}">
		  </div>
		  <div class="form-group">
		    <label for="desc">Project Description</label>
		    <textarea name="desc" class="form-control" placeholder="Enter description or Mission Statement" rows=7>{{ old('desc') }}</textarea>
		  </div>
		  <div class="form-group">
		    <label for="project_owner">Project Owner</label>
		    	<select class="form-control" name="project_owner">
				  @foreach ($users as $user)
				  	<option>{{ $user->name }}</option>
				  @endforeach
				</select>
		  </div>
		  
		  <div class="checkbox">
		    <label>
		      <input type="checkbox"> Check me out
		    </label>
		  </div>

		  <button type="submit" class="btn btn-default">Submit</button>
	</form>
</div>


@stop