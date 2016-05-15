@extends('layout')

@section('content')

@include('partials.msg')

<!-- PROJECT FILES MODAL -->
<div class="row">
	<div id="filesModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="filesLabel" aria-hidden="true" style="display: none;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header" style="border-bottom: 1px solid #fff;">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title" id="newImageLabel">{{ $project->name }} Files</h4>
				</div>
				<div class="modal-body">

					<!-- Nav tabs -->
					<ul class="nav nav-tabs" role="tablist" style="margin-bottom:20px;">
						<li role="presentation" class="active" ><a data-toggle="tabajax" href="/project/{{ $project->id }}/files" aria-controls="home" role="tab" data-toggle="tab" data-target="#fileslist">Project files</a></li>
						<!--li role="presentation"><a href="#upl" aria-controls="profile" role="tab" data-toggle="tab">Upload project image</a></li-->
						<li role="presentation"><a href="#uplfiles" aria-controls="profile" role="tab" data-toggle="tab">Upload files</a></li>
					</ul>
		
					<div class="tab-content">
						<div role="tabpanel" class="tab-pane active" id="fileslist">
							<div class="alert alert-success" id="deletesuccess" style="display:none;">
   								<span class="glyphicon glyphicon-ok"></span><em> File deleted </em>
   							</div>
							<table class="table table-condensed">
								<tr>
									<th>Filename</th>
									<th>Uploaded by</th>
									<th>Uploaded</th>
									<th></th>
								<tr>
									<tbody>
									@if ($project->ProjectFile->isEmpty())
										<tr class="info"><td colspan=4>&nbsp;<em>No files uploaded</em></td></tr>
									@else
										@foreach ($project->ProjectFile as $file)
											<tr id="tr{{ $file->id }}">
												<td><a href="/download/{{base64_encode($file->path . $file->name)}}" title="{{ basename($file->name) }}"><span class="glyphicon glyphicon-file"></span> {{ str_limit(basename($file->name), 28) }}</a></td>
												<td>{{ \Helpers\UserIdToName($file->user_id) }}</td>
												<td>{{ $file->created_at }}</td>
												<td><a href="/file/{{ $file->id }}/delete" class="deleteFile" data-file-id="{{ $file->id }}"><small><span class="glyphicon glyphicon-trash"></span></small></a></td>
											</tr>
										@endforeach
									@endif
									</tbody>
							</table>
						</div> <!-- / tabpanel fls-->

						<div role="tabpanel" class="tab-pane" id="upl">
							<form role="form" action="/project/{{ $project->id }}/store/image" method="POST" id="my-awesome-dropzone" class="dropzone" style="margin-top:20px;">
								{{ csrf_field() }}
								<div class="form-group">
									<div id="dropzone-previews" class="dz-default dz-message">
		  								<span>Drag project image file here, or click to upload</span>
									</div>
								</div>
							</form>
							<div class="pull-right" style="margin-top:20px;">
				  				<a href="/project/{{ $project->id }}" id="done" type="button" style="display:none;" class="btn btn-primary">Ok</a>
				 			</div>
    					</div>
    		
    					<div role="tabpanel" class="tab-pane" id="uplfiles">
							<form role="form" action="/project/{{ $project->id }}/store/file" method="POST" id="projectFilesDropzone" class="dropzone" style="margin-top:20px;">
								{{ csrf_field() }}
								<div class="form-group">
									<div id="dropzone-previews" class="dz-default dz-message">
										<span>Drag files here, or click to upload</span>
									</div>
								</div>
							</form>
							<div class="pull-right" style="margin-top:20px;">
			  					<a href="/project/{{ $project->id }}" id="donebutton" type="button" style="display:none;" class="btn btn-primary">Ok</a>
			 				</div>
    					</div>


					</div> <!-- tab-content -->
				</div><!-- /.modal-body -->		
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div> <!-- /files_modal -->
</div> <!-- /row -->

<!-- NEW TASK MODAL -->

	<div id="newTaskModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="newTaskLabel" aria-hidden="true" style="display: none;">
		<div class="modal-dialog">
			<div class="modal-content"  style="background: #eae672;">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title" id="newTaskLabel">Create New task</h4>
				</div>
				<div class="modal-body">
					<form method="POST" action="/project/{{ $project->id }}/tasks" role="form">
						{{ csrf_field() }}
						<div class="form-group">
							<label for="taskName">Name</label>
							<input type="text" class="form-control" id="taskName" name="taskName" placeholder="Enter task name" required value="{{ old('taskName') }}">
						</div>
						<div class="form-group">
							<label for="taskResponsible">Responsible</label>
							<select class="form-control" id="taskResponsible" name="taskResponsible">
								@foreach ($allusers as $us)
									@if ($us->id == Auth::id())
										<option value="{{ $us->id }}" SELECTED>{{ $us->name }}</option>
									@else
										<option value="{{ $us->id }}">{{ $us->name }}</option>
									@endif
				  				@endforeach
							</select>
						</div>
						<div class="form-group">
							<label for="taskDesc">Description</label>
							<textarea class="form-control" rows="3" id="taskDesc" name="taskDesc" >{{ old('taskDesc') }}</textarea>
						</div>
						<div class="form-group">
							<label for="taskPhase">Project Phase</label>
							<select class="form-control" id="taskPhase" name="taskPhase">
								<option value="backlog" SELECTED>Research</option>
								<option value="backlog_2">Design</option>
								<option value="backlog_3">Deliver</option>
							</select>
						</div>
						<div class="form-group">
							<label for="taskDeadline">Deadline</label>
							<input type="date" class="form-control" id="taskDeadline" name="taskDeadline" placeholder="yyyy-mm-dd" value="{{ old('taskDeadline') }}" required>
						</div>
						<div class="row">
							<div class="col-md-12">
								<button type="submit" class="btn btn-default pull-right">Create Task</button>
							</div>
						</div>
						
					</form>
				</div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div>

@if (isset($project->close_date))
	<div class="alert alert-danger">
		<strong><span class="glyphicon glyphicon-warning-sign"></span> This project is archived</strong>
	</div>
@endif
<div class="row">
	<div class="col-md-12 media" style="margin-bottom: 20px;margin-top:20px;">		
  		<a class="pull-left" href="#">
  			@if (isset($project->img))
    			<img class="img-thumbnail img-responsive media-object" src="/img/projectuploads/{{ $project->img }}" style="max-height:150px;max-width:250px;">
    		@else
    			<img class="img-thumbnail img-responsive media-object" src="/img/default_project_image.jpg" style="max-height:150px;max-width:250px;">
    		@endif
  		</a>
  		<div class="media-body">
    		<h1 class="media-heading">#{{ $project->id }} {{ $project->name }}</h1>
    		<p class="lead">{{ $project->desc }}</p>
    		<p>
				<small>
					<!--Client: <em>To Be Implemented</em><br />-->
					Project owner: {{ $project->user->name }} &nbsp;&nbsp;<br />
		    		@if ($project->deadline)
		    			Deadline: {{ $project->deadline->diffForHumans() }} &nbsp;&nbsp;
		    		@else
		    			Deadline: TBD &nbsp;&nbsp;
		    		@endif
		    	</small>
    		</p>
    		<hr />
    		<p class="pull-right">
    			<!--a data-toggle="modal" data-target="#filesModal" href=#><span class="glyphicon glyphicon-cloud-upload"></span> Upload Files </a>&nbsp;&nbsp;-->
    			<a data-toggle="modal" data-target="#filesModal" href=#><span class="glyphicon glyphicon-file"></span> Project Files <span id="nbroffiles" class="badge" style="background-color: #CA4242;">{{ count($project->ProjectFile) }}</span></a>&nbsp;&nbsp;
	    		<!--a href=#><span class="glyphicon glyphicon-time"></span> Start timer </a>&nbsp;&nbsp;-->
	    		<a href="/project/{{ $project->id }}/edit"><span class="glyphicon glyphicon-edit"></span> Edit Project</a>
    		</p>
  		</div>
	</div>
</div>

<!--div class="row">
	<div class="col-md-12 media" style="margin-bottom: 20px;">
		<div class="btn-group" role="group" aria-label="...">
  			<div class="btn-group" role="group">
			    <button type="button" class="btn btn-default"><span class="glyphicon glyphicon-scale" aria-hidden="true"></span> Research</button>
			  </div>
			  <div class="btn-group" role="group">
			    <button type="button" class="btn btn-default"><span class="glyphicon glyphicon-scissors
			" aria-hidden="true"></span> Design</button>
			  </div>
			  <div class="btn-group" role="group">
			    <button type="button" class="btn btn-default"><span class="glyphicon glyphicon-paperclip" aria-hidden="true"></span>Deliver</button>
			  </div>
		</div>
	</div>
</div-->

@include('partials.error')


<div class="row">
	<div class="col-md-12"> 
<table class="table table-bordered">
        <thead>
          <tr class="active">
            <th width=4%>&nbsp;</th>
            <th width=32%>Backlog <button data-toggle="modal" data-target="#newTaskModal" type="button" class="btn btn-default btn-xs pull-right"><span data-toggle="tooltip" data-placement="top" title="Click to add task" class="glyphicon glyphicon-plus" style="opacity: .5;"></span></button></th>
            <th width=32%>Ongoing</th>
            <th width=32%>Done</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th>
				<svg width="50" height="175">
            		<text x="80" y="150" transform="rotate(-90, 28, 150)" style="text-anchor:middle;">Research</text>
        		</svg>

            </th>
            <td>

				@if (count($project->tasks) === 0)
		  			<p class="text-center" style="height:110px;margin-top:30px;"><em>Click the "plus" above and add a task..<br />..or <a href="/project/{{ $project->id }}/kickstart">click here</a> to kick start the project!</em></p>
		  		@else
			  		<div id="backlog" class="dragndropzone">
			  			@foreach ($project->tasks as $task)
				  			@if ($task->stage == 'backlog')
				  				@include('partials.tablepostit')
							@endif
		  				@endforeach
		  			</div>
	  			@endif
            </td>
            <td>
				<div id="ongoing" class="dragndropzone">
		  			@foreach ($project->tasks as $task)
		  				@if ($task->stage == 'ongoing')
		  					@include('partials.tablepostit')
		  				@endif
		  			@endforeach
	  			</div>
            </td>
            <td>
				<div id="done" class="dragndropzone">
		  			@foreach ($project->tasks as $task)
		  				@if ($task->stage == 'done')
		  					@include('partials.tablepostit')
		  				@endif
		  			@endforeach
	  			</div>
            </td>
          </tr>
          <tr>
            <th>
				<svg width="50" height="175">
            		<text x="80" y="150" transform="rotate(-90, 28, 150)" style="text-anchor:middle;">Design</text>
        		</svg>

            </th>
            <td>
            	<div id="backlog_2" class="dragndropzone">
		  			@foreach ($project->tasks as $task)
			  			@if ($task->stage == 'backlog_2')
			  				@include('partials.tablepostit')
						@endif
			  		@endforeach
		  		</div>
            </td>
            <td>
				<div id="ongoing_2" class="dragndropzone">
		  			@foreach ($project->tasks as $task)
		  				@if ($task->stage == 'ongoing_2')
		  					@include('partials.tablepostit')
		  				@endif
		  			@endforeach
	  			</div>
            </td>
            <td>
            	<div id="done_2" class="dragndropzone">
		  			@foreach ($project->tasks as $task)
		  				@if ($task->stage == 'done_2')
		  					@include('partials.tablepostit')
		  				@endif
		  			@endforeach
	  			</div>
            </td>
          </tr>
          <tr>
            <th>
				<svg width="50" height="175">
            		<text x="80" y="150" transform="rotate(-90, 28, 150)" style="text-anchor:middle;">Deliver</text>
        		</svg>

            </th>
            <td>
            	<div id="backlog_3" class="dragndropzone">
		  			@foreach ($project->tasks as $task)
			  			@if ($task->stage == 'backlog_3')
			  				@include('partials.tablepostit')
						@endif
			  		@endforeach
		  		</div>
            </td>
            <td>
				<div id="ongoing_3" class="dragndropzone">
		  			@foreach ($project->tasks as $task)
		  				@if ($task->stage == 'ongoing_3')
		  					@include('partials.tablepostit')
		  				@endif
		  			@endforeach
	  			</div>
            </td>
            <td>
            	<div id="done_3" class="dragndropzone">
		  			@foreach ($project->tasks as $task)
		  				@if ($task->stage == 'done_3')
		  					@include('partials.tablepostit')
		  				@endif
		  			@endforeach
	  			</div>
            </td>
          </tr>
        </tbody>
      </table>
  </div>
</div>

<script src='/js/dragula.js'></script>
<script src="/js/dropzone.js"></script>
<script>

/* Drag & drop script */
function $(id) 
{
  return document.getElementById(id);
}

dragula([	$('backlog'),
			$('backlog_2'), 
			$('backlog_3'),
			$('ongoing'), 
			$('ongoing_2'), 
			$('ongoing_3'), 
			$('done'),
			$('done_2'),
			$('done_3')], {
  revertOnSpill: true
}).on('drop', function(el, target, source, sibling) {
  
  	var target = target.id;
	var taskid = el.id;
  	

  	// update state for this task
  	updateTask(target, taskid);

  	// notify if task was blocking another task
  	// handleBlocks(target, taskid); // notify responsible and remove the block!

	return;
});

function updateTask(target, taskid) 
{
    
    var token = $('meta[name=csrf-token]').attr("content");

    $.ajax({

    	type: 'POST',
    	url: '/tasks/' + taskid + '/stage',
    	data: {
    			'target': target, 
    			'taskid': taskid, 
    			'_token': token
    		},
    	timeout: 2000, // sets timeout to 2 seconds and error will be thrown
    	/*
    	success: function() 
    	{
    		alert("done!");
    	},
    	*/
    	error: function(jqXHR, textStatus, errorThrown) 
    	{
    		if(textStatus === 'timeout')
    		{     
        		alert('Moving the Task failed from timeout. Please try again.'); 
		    }
		    else
		    {
		    	alert('Sorry :( Error occurred...status code:' + jqXHR.status + ', Error: ' + errorThrown);	
		    }
			
		}

    });
    return true;
}


</script>
@stop

@section('scripts')
	<script type="text/javascript">

		// use ajax to load project files in tab
	    $('[data-toggle="tabajax"]').on("click", function(e) { 
	        	//alert("klicked!");
				//var $this = $(this),
	          	var loadurl = $(this).attr('href');
	          	var targ = $(this).attr('data-target');
	          
	          	//alert(targ);
	           	$(targ).load(loadurl);
	           	$(this).tab('show');
	          	return false;
	    });

		// use ajax to submit updates on 
		// task changes.
		(function(){

			$('.ajax').submit(function(e) { // I removed this class from form to not use Ajax
				
				// disable the submit button
				$('#updateTask').addClass('disabled');

				var form = $(this);
				var method = form.find('input[name="_method"]').val() || 'POST';
				var url = form.prop('action');

				$.ajax({

					type: method,
					url: url,
					data: form.serialize(),
					success: function() 
		    		{
		    			//alert("done!");
		    			$('#tasksuccess').show().delay(1000).fadeOut();
		    			$('#updateTask').removeClass('disabled');
		    		},
		    	

		    	});
				return false;
				e.preventDefault();

			});

		})();

		// delete files using ajax
		(function(){

			// only accept one click
			//$('.deleteFile').one('click', function(e) { 
			$(document).on("click", '.deleteFile', function(e) { 
   				
   				e.preventDefault();
				$(this).addClass('disabled');
				var loadurl = $(this).attr('href');
	          	var fileid = $(this).attr('data-file-id');

				$.ajax({

					url: loadurl,
					success: function() 
		    		{
		    			
		    			$('#tr' + fileid).fadeToggle(1000);
		    			//$('#deletesuccess').fadeIn().delay(2000).fadeOut();
		    			$("#nbroffiles").text( Number($("#nbroffiles").text()) - 1);
		    			//$('#updateTask').removeClass('disabled');
		    		},
		    	

		    	});
				return false;

			});

		})();

		// Remove block using ajax
		(function(){

			// only accept one click
			$('.removeblock').one('click', function(e) { 
   				
   				e.preventDefault();
				$(this).addClass('disabled');
				var loadurl = $(this).attr('href');
				var taskid = $(this).attr('data-task-id');
	          	var blockedbytaskid = $(this).attr('data-block-id');

				$.ajax({

					url: loadurl,
					success: function() 
		    		{
		    			
		    			// remove the appropriate blocker icon
		    			$('span > [data-blocker="' + blockedbytaskid + '"]').hide();
		    			// remove the alert-div itself
		    			$('#blockinfo' + blockedbytaskid).fadeOut();
		    			// remove the hidden value from the form
		    			$('#hiddenTaskBlock' + blockedbytaskid).remove();
		    			// display the blocked by search form that was hidden
						$('#TaskBlockSearch' + taskid).fadeIn();		    			
		    					    			
		    		},
		    	

		    	});
				return false;

			});

		})();

		

		/* DROPZONE FILE UPLOAD */
		Dropzone.options.projectFilesDropzone = { // The camelized version of the ID of the form element

		  uploadMultiple: true,
		  maxFiles: 10,
		  maxFileSize: 100,

		  init: function() {
		    var myDropzone = this;


		    this.on("success", function(files, response) {
		    	$("#nbroffiles").text( Number($("#nbroffiles").text()) + 1);
		      // Gets triggered when the file successfylly been uploaded
		      // now show the ok button!
		      //$('#donebutton').show();
		      
		    });
		    
		  }

		}

	</script>
@stop