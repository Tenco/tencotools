@extends('layout')

@section('content')

<div class="row col-md-8 col-md-offset-2">
	<h1>Create new project</h1>
	<form role="form" action="/project/store" method="POST">
		{{ csrf_field() }}
		@include('partials.error')
		  <div class="form-group">
		    <label for="name">Project Name</label>
		    <input type="name" class="form-control" id="name" placeholder="Enter name" name="name" value="{{ old('name') }}" required>
		  </div>
		  <div class="form-group">
		    <label for="desc">Project Description</label>
		    <textarea name="desc" class="form-control" placeholder="Enter description or Mission Statement" rows=7>{{ old('desc') }}</textarea>
		  </div>
		  <div class="form-group">
		    <label for="project_owner">Project Owner</label>
		    	<select class="form-control" name="project_owner">
				  @foreach ($users as $user)
				  	<option value="{{ $user->id }}">{{ $user->name }}</option>
				  @endforeach
				</select>
		  </div>
		   <div class="form-group">
		    <label for="value">Project Value</label>
		    <div class="input-group">
  			<span class="input-group-addon">kr</span>
		    	<input type="name" name="value" class="form-control" id="value" placeholder="Enter value" value="{{ old('value') }}">
		    </div>
		  </div>
		  <div class="form-group">
		    <label for="cost">Project Cost</label>
		    <div class="input-group">
  			<span class="input-group-addon">kr</span>
		    	<input type="name" name="cost" class="form-control" id="cost" placeholder="Enter Cost" value="{{ old('cost') }}">
		    </div>
		  </div>
		  <div class="form-group">
		    <label for="name">Project Deadline</label>
		    <input type="date" name="deadline" class="form-control" id="deadline" placeholder="Enter Deadline" value="{{ old('deadline') }}">
		  </div>
		  <!--div class="checkbox">
		    <label>
		      <input type="checkbox"> Check me out
		    </label>
		  </div-->
			<div class="pull-right"><a type="button" class="btn btn-default" href="/">Cancel</a>
		  <button type="submit" class="btn btn-primary">Next <span class="glyphicon glyphicon-arrow-right"></span></button></div>
	</form>
</div>

@stop