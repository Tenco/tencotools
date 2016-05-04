@extends('layout')

@section('content')

<div class="row col-md-8 col-md-offset-2">
	<h1>Create relation</h1>
	<form role="form" action="/relation/store" method="POST">
		{{ csrf_field() }}
		@include('partials.error')
		  <div class="form-group">
		    <label for="name">Name</label>
		    <input type="name" class="form-control input-lg" id="name" placeholder="Enter name" name="name" value="{{ old('name') }}" required>
		  </div>
		  <div class="form-group">
		    <label for="value">Company name</label>
		    
  		    	<input type="text" name="company" class="form-control input-lg" id="company" placeholder="Company name" value="{{ old('company') }}">
		    
		  </div>
		  <div class="form-group">
		    <label for="desc">E-mail address</label>
		    <input type="email" class="form-control input-lg" id="email" placeholder="Enter e-mail" name="email" value="{{ old('email') }}" required>
		  </div>
		  <div class="form-group">
		    <label for="value">Phone number</label>
		    
  		    	<input type="text" name="phone" class="form-control input-lg" id="phone" placeholder="Phone number" value="{{ old('phone') }}">
		    
		  </div>
		  
		   <div class="form-group">
		    <label for="project_owner">Tenco contact</label>
		    	<select class="form-control input-lg" name="tenco_contact">
					@foreach ($users as $us)
						@if ($us->id == Auth::id())
							<option value="{{ $us->id }}" SELECTED>{{ $us->name }}</option>
						@else
							<option value="{{ $us->id }}">{{ $us->name }}</option>
						@endif
					@endforeach
				</select>
		  </div>
		  <div class="checkbox">
		    <label>
		      <input type="checkbox" checked> Accepts sendouts
		    </label>
		  </div>
			<div class="pull-right"><a type="button" class="btn btn-default" href="/relations">Cancel</a>
		  <button type="submit" class="btn btn-primary">Next <span class="glyphicon glyphicon-arrow-right"></span></button></div>
	</form>
</div>

@stop