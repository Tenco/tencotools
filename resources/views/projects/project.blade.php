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
					<!--h4 class="modal-title" id="newImageLabel">Project Files</h4-->
				</div>
				<div class="modal-body">
					<table class="table table-condensed">
						<tr>
							<th>Filename</th>
							<th>Uploaded by</th>
							<th>Uploaded</th>
							<th></th>
						<tr>
							<tbody>
							@if ($project->ProjectFile->isEmpty())
								<tr class="info"><td colspan=4>&nbsp;No files uploaded. Upload files in <a href="/project/{{ $project->id }}/edit">Edit Project</a></td></tr>
							@else
								@foreach ($project->ProjectFile as $file)
									<tr>
										<td><a href="/download/{{base64_encode($file->path . $file->name)}}" title="{{ basename($file->name) }}"><span class="glyphicon glyphicon-file"></span> {{ str_limit(basename($file->name), 28) }}</a></td>
										<td>{{ \Helpers\UserIdToName($file->user_id) }}</td>
										<td>{{ $file->created_at }}</td>
										<td><a href="/file/{{ $file->id }}/delete"><small><span class="glyphicon glyphicon-trash"></span></small></a></td>
									</tr>
								@endforeach
							@endif
							</tbody>
					</table>
				</div><!-- /.modal-body -->		
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div>
</div>

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
							<label for="taskDeadline">Deadline</label>
							<input type="date" class="form-control" id="taskDeadline" name="taskDeadline" placeholder="yyyy-mm-dd" value="{{ old('taskDeadline') }}">
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
					Client: <em>To Be Implemented</em><br />
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
    			<a data-toggle="modal" data-target="#filesModal" href=#><span class="glyphicon glyphicon-file"></span> Project Files</a>&nbsp;&nbsp;
	    		<!--a href=#><span class="glyphicon glyphicon-time"></span> Start timer </a>&nbsp;&nbsp;-->
	    		<a href="/project/{{ $project->id }}/edit"><span class="glyphicon glyphicon-cog"></span> Edit Project</a>
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
	<div class="col-md-4"> 
		<div class="panel panel-primary">
			<div class="panel-heading">
	    		<h3 class="panel-title">Backlog<button data-toggle="modal" data-target="#newTaskModal" type="button" class="btn btn-default btn-xs pull-right"><span data-toggle="tooltip" data-placement="top" title="Click to add task" class="glyphicon glyphicon-plus" style="opacity: .5;"></span></button></h3>
	  		</div>
	  		<div class="panel-body">
	  			@if (count($project->tasks) === 0)
		  				<p class="text-center" style="height:110px;margin-top:30px;"><em>Click the "plus" above and add a task..<br />..or <a href="/project/{{ $project->id }}/kickstart">click here</a> to kick start the project!</em></p>
		  			@else
	    		<div id="backlog" class="dragndropzone">
		  				@foreach ($project->tasks as $task)
			  				@if ($task->stage == 'backlog')
			  					@include('partials.postit')
			  				@endif
		  				@endforeach
	  			</div>
	  			@endif
	  		</div>
		</div>	<!-- / panel -->
	</div> <!-- / col-md-4 -->

	<div class="col-md-4"> 
		<div class="panel panel-primary">
			<div class="panel-heading">
	    		<h3 class="panel-title">Ongoing</h3>
	  		</div>
	  		<div class="panel-body">
	    		<div id="ongoing" class="dragndropzone">
		  			@foreach ($project->tasks as $task)
		  				@if ($task->stage == 'ongoing')
		  					@include('partials.postit')
		  				@endif
		  			@endforeach
	  			</div>
	  		</div>
		</div>	<!-- / panel -->
	</div> <!-- / col-md-4 -->

  	<div class="col-md-4"> 
		<div class="panel panel-primary">
			<div class="panel-heading">
	    		<h3 class="panel-title">Done</h3>
	  		</div>
	  		<div class="panel-body">
	    		<div id="done" class="dragndropzone">
		  			@foreach ($project->tasks as $task)
		  				@if ($task->stage == 'done')
		  					@include('partials.postit')
		  				@endif
		  			@endforeach
	  			</div>
	  		</div>
		</div>	<!-- / panel -->
	</div> <!-- / col-md-4 -->
	
</div> <!-- / row -->


<script src='/js/dragula.js'></script>
<!--script src="/js/sweetalert.min.js"></script-->
<script>

/* Drag & drop script */
function $(id) 
{
  return document.getElementById(id);
}

dragula([$('backlog'), $('ongoing'), $('done')], {
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
    	data: {'target': target, 'taskid': taskid, '_token': token},
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


	/* Sweet alert
	swal({   
		title: "Error!",   
		text: "Here's my error message!",   
		type: "error",   
		confirmButtonText: "Cool" 
	});
	*/


</script>

@stop