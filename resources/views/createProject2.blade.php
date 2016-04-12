@extends('layout')

@section('content')
<div class="row col-md-8 col-md-offset-2">

	<h1>Upload Project Image</h1>

	
		<form role="form" action="/project/{{ $project->id }}/store/image" method="POST" id="my-awesome-dropzone" class="dropzone" style="margin-top:20px;">
			{{ csrf_field() }}
			<div class="form-group">
				<div id="dropzone-previews" class="dz-default dz-message">
					<span>Drag project image file here</span>
				</div>
			</div>

		</form>

		<div class="pull-right" style="margin-top:20px;">
		  		<a href="/project/{{ $project->id }}" type="button" class="btn btn-primary">Done</a>
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