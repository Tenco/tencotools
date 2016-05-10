@extends('layout')

@section('content')
<div class="row col-md-8 col-md-offset-2">
@include('partials.msg')
	<h1>Edit contact</h1>

	<!-- Nav tabs -->
		<ul class="nav nav-tabs" role="tablist">
			<li role="presentation" class="active"><a href="#fls" aria-controls="home" role="tab" data-toggle="tab">Contact details</a></li>
			<li role="presentation"><a href="#upl" aria-controls="profile" role="tab" data-toggle="tab">Contact image</a></li>
		</ul>
		
	<!-- Tab panes -->
	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active" id="fls">
			<form role="form" action="/relations/{{ $relation->id }}/update" method="POST" style="margin-top:20px;">
				<input name="_method" type="hidden" value="PATCH">
				{{ csrf_field() }}
				@include('partials.error')
				<div class="form-group">
					<label for="name">Name</label>
					<input type="name" class="form-control input-lg" id="name" placeholder="Enter name" name="name" value="{{ $relation->name }}" required>
				</div>
				<div class="form-group">
					<label for="value">Company name</label> 
					<input type="text" name="company" class="form-control input-lg" id="company" placeholder="Company name" value="{{ $relation->company }}">
				</div>
				<div class="form-group">
					<label for="desc">E-mail address</label>
					<input type="email" class="form-control input-lg" id="email" placeholder="Enter e-mail" name="email" value="{{ $relation->email }}" required>
				</div>
				<div class="form-group">
					<label for="value">Phone number</label> 
					<input type="text" name="phone" class="form-control input-lg" id="phone" placeholder="Phone number" value="{{ $relation->phone }}"> 
				</div> 
				<div class="form-group">
					<label for="tenco_contact">Tenco contact</label>
					<select class="form-control input-lg" name="tenco_contact">
						@foreach ($allusers as $user)
							@if ($user->id === $relation->tenco_contact)
								<option value="{{ $user->id }}" SELECTED>{{ $user->name }}</option>
							@else
								<option value="{{ $user->id }}">{{ $user->name }}</option>
							@endif
						@endforeach
					</select>
				</div>
				<!--div class="checkbox">
					<label><input type="checkbox"> Accepts sendouts</label>
				</div-->
				<div>
					<a href="/relations/{{ $relation->id }}/delete" type="button" class="btn btn-danger">Delete Contact</a>
					<div class="pull-right">
						<a type="button" class="btn btn-default" href="/relations">Cancel</a>
						<button type="submit" class="btn btn-primary">Save</button>
				</div>
				</div>
			</form>

			</div>    
			<div role="tabpanel" class="tab-pane" id="upl">
				<form role="form" action="/relation/{{ $relation->id }}/store/image" method="POST" id="updateRelationImageDropzone" class="dropzone" style="margin-top:20px;">
						{{ csrf_field() }}
						<div class="form-group">
							<div id="dropzone-previews" class="dz-default dz-message">
  								<span>Drag image file here, or click to upload</span>
							</div>
						</div>
					</form>
					<div class="pull-right" style="margin-top:20px;">
		  				<a href="/relations" type="button" id="done" class="btn btn-primary" style="display:none;">Done</a>
		 			</div>
    		</div>
		</div>


	
</div>

@stop

@section('scripts')
<script src="/js/dropzone.js"></script>
<script>
/* DROPZONE IMAGE UPLOAD */
Dropzone.options.updateRelationImageDropzone = { // The camelized version of the ID of the form element

  // The configuration we've talked about above
  uploadMultiple: false,
  parallelUploads: 100,
  maxFiles: 1,
  maxFileSize: 100,
  acceptedFiles: '.jpg, .png, .jpeg',
  
  // The setting up of the dropzone
  init: function() {
    var myDropzone = this;


    this.on("success", function(files, response) {
      // Gets triggered when the file successfylly been uploaded
      // now show the ok button!
      if(response.error)
      {
      	alert("Errror: " + response.error);
      }

      $('#done').show();
      
    });
    
  }


}

</script>

@stop