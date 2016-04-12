@extends('layout')

@section('content')
<div class="row col-md-8 col-md-offset-2">
	@if (isset($project->close_date))
	<div class="alert alert-danger">
		<strong><span class="glyphicon glyphicon-warning-sign"></span> This project is archived</strong>
	</div>
@endif
	<h1>Edit project</h1>

	<!-- Nav tabs -->
		<ul class="nav nav-tabs" role="tablist">
			<li role="presentation" class="active"><a href="#fls" aria-controls="home" role="tab" data-toggle="tab">Project details</a></li>
			<li role="presentation"><a href="#upl" aria-controls="profile" role="tab" data-toggle="tab">Project image</a></li>
		</ul>
		
	<!-- Tab panes -->
		<div class="tab-content">
			<div role="tabpanel" class="tab-pane active" id="fls">

				<form role="form" action="/project/{{ $project->id }}/update" method="POST" style="margin-top:20px;">
					<input name="_method" type="hidden" value="PATCH">
					{{ csrf_field() }}
					@include('partials.error')
					  <div class="form-group">
					    <label for="name">Project Name</label>
					    <input type="name" class="form-control" id="name" placeholder="Enter name" name="name" value="{{ $project->name }}" required>
					  </div>
					  <div class="form-group">
					    <label for="desc">Project Description</label>
					    <textarea name="desc" class="form-control" placeholder="Enter description or Mission Statement" rows=7>{{ $project->desc }}</textarea>
					  </div>
					  <div class="form-group">
					    <label for="project_owner">Project Owner</label>
					    	<select class="form-control" name="project_owner">
							  @foreach ($allusers as $user)
							  	@if ($user->id === $project->project_owner)
							  		<option value="{{ $user->id }}" SELECTED>{{ $user->name }}</option>
							  	@else
							  		<option value="{{ $user->id }}">{{ $user->name }}</option>
							  	@endif
							  @endforeach
							</select>
					  </div>
					   <div class="form-group">
					    <label for="value">Project Value</label>
					    <div class="input-group">
			  			<span class="input-group-addon">kr</span>
					    	<input type="name" name="value" class="form-control" id="value" placeholder="Enter value" value="{{ $project->value }}">
					    </div>
					  </div>
					  <div class="form-group">
					    <label for="cost">Project Cost</label>
					    <div class="input-group">
			  			<span class="input-group-addon">kr</span>
					    	<input type="name" name="cost" class="form-control" id="cost" placeholder="Enter Cost" value="{{ $project->cost }}">
					    </div>
					  </div>
					  <div class="form-group">
					    <label for="name">Project Deadline</label>
					    @if (isset($project->deadline))
							{{ $project->deadline->diffForHumans() }} <!--&nbsp;&nbsp;&nbsp;<small><a href=#>change</a></small-->
							<input type="hidden" name="deadline" value="{{ $project->deadline }}">
						@else
							<input type="date" name="deadline" class="form-control" id="deadline" placeholder="Enter Deadline" value="{{ $project->deadline }}">
						@endif
					  </div>
					  <!--div class="checkbox">
					    <label>
					      <input type="checkbox"> Check me out
					    </label>
					  </div-->
						@if (isset($project->close_date))
							<a href="/project/{{ $project->id }}/revive" type="button" class="btn btn-success">Revive Project</a>
						@else
							<a href="/project/{{ $project->id }}/archive" type="button" class="btn btn-danger">Archive Project</a>
						@endif
					  
						<div class="pull-right"><a type="button" class="btn btn-default" href="/project/{{ $project->id }}">Cancel</a>
					  <button type="submit" class="btn btn-primary">Save</button></div>
				</form>

			</div>    
			<div role="tabpanel" class="tab-pane" id="upl">
				<form role="form" action="/project/{{ $project->id }}/store/image" method="POST" id="my-awesome-dropzone" class="dropzone" style="margin-top:20px;">
						{{ csrf_field() }}
						<div class="form-group">
							<div id="dropzone-previews" class="dz-default dz-message">
  								<span>Drag project image file here</span>
							</div>
						</div>
					</form>
    		</div>
		</div>


	
</div>

<script src="/js/dropzone.js"></script>
<script>
/* DROPZONE IMAGE UPLOAD */

Dropzone.options.myAwesomeDropzone = { // The camelized version of the ID of the form element

  // The configuration we've talked about above
  uploadMultiple: false,
  parallelUploads: 100,
  maxFiles: 1,
  maxFileSize: 2,
  acceptedFiles: '.jpg, .png, .jpeg',
  
  // The setting up of the dropzone
  init: function() {
    var myDropzone = this;


    this.on("success", function(files, response) {
      // Gets triggered when the file successfylly been uploaded
      // now show the ok button!
      $('#reloadProject').show();
      
    });
    
  }


}
</script>

@stop