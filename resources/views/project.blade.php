@extends('layout')

@section('content')

@include('partials.msg')


<!-- PROJECT IMAGE UPLOAD MODAL -->
<div class="row">
	<div id="newImageModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="newImageLabel" aria-hidden="true" style="display: none;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title" id="newImageLabel">Upload Project Image</h4>
				</div>
				<div class="modal-body">
					<form role="form" action="/project/{{ $project->id }}/store/image" method="POST" id="my-awesome-dropzone" class="dropzone" >
						{{ csrf_field() }}
						<div class="form-group">
							<div id="dropzone-previews" class="dz-default dz-message">
  								<span>Drag project image file here</span>
							</div>
						</div>
					</form>
					<div class="row" id="reloadProject" style="display:none;">
						<p><a href="/project/{{ $project->id }}"  type="button" class="btn btn-primary pull-right" style="margin-right:20px;margin-top:20px;">Ok</a></p>
					</div>
				</div>
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
				  					<option value="{{ $us->id }}">{{ $us->name }}</option>
				  				@endforeach
							</select>
						</div>
						<div class="form-group">
							<label for="taskDesc">Description</label>
							<textarea class="form-control" rows="3" id="taskDesc" name="taskDesc" >{{ old('taskDesc') }}</textarea>
						</div>
						<button type="submit" class="btn btn-default">Create Task</button>
					</form>
				</div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div>

<!-- EDIT PROJECT MODAL -->
<div class="row">
	<div id="editProjectModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editProjectModal" aria-hidden="true" style="display: none;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title">Edit Project {{ $project->name}} </h4>
				</div>
				<div class="modal-body">
					<form method="POST" action="/project/{{ $project->id }}" role="form">
						{{ method_field('PATCH') }}
						{{ csrf_field() }}
						<div class="form-group">
							<label for="taskName">Name</label>
							<input type="text" class="form-control" id="taskName" name="taskName" placeholder="Enter task name" value="{{ $project->name}}" required>
						</div>
						<div class="form-group">
							<label for="taskDesc">Description</label>
							<textarea class="form-control" rows="3" id="taskDesc" name="taskDesc" required>{{ $project->desc}}</textarea>
						</div>
						<button type="submit" class="btn btn-default">Submit</button>
					</form>
				</div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div>
</div>



<div class="row">
	<div class="col-md-12 media" style="margin-bottom: 20px;">
  		<a class="pull-left" href="#" data-toggle="modal" data-target="#newImageModal">
    		<img class="img-circle img-responsive media-object" src="/img/uprojectuploads/{{ $project->img }}" style="max-width:150px;">
  		</a>
  		<div class="media-body">
    		<h1 class="media-heading">{{ $project->name }}</h1>
    		<em>{{ $project->desc }}</em>
    		<hr />
    		<p class="pull-right">
    			<span class="glyphicon glyphicon-user"></span> {{ $project->user->name }} &nbsp;&nbsp;
	    		<span class="glyphicon glyphicon-calendar"></span> deadline 2016-07-01 &nbsp;&nbsp;
	    		<a href=#><span class="glyphicon glyphicon-time"></span> Start timer </a>&nbsp;&nbsp;
	    		<a href="project/{{ $project->id }}/edit" data-toggle="modal" data-target="#editProjectModal" data-remote="false"><span class="glyphicon glyphicon-edit"></span> edit</a>  &nbsp;&nbsp;
	    		<a href="#"><span class="glyphicon glyphicon-folder-open"></span> &nbsp;archive</a>
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
	    		<h3 class="panel-title">Backlog<button data-toggle="modal" data-target="#newTaskModal" type="button" class="btn btn-default btn-xs pull-right"><span class="glyphicon glyphicon-plus" style="opacity: .5;"></span></button></h3>
	  		</div>
	  		<div class="panel-body">
	  			@if (count($project->tasks) === 0)
		  				<p class="text-center" style="height:110px;margin-top:30px;"><em>Click the "plus" above and add some tasks..</em></p>
		  			@else
	    		<div id="backlog" class="dragndropzone">
		  				@foreach ($project->tasks as $task)
			  				@if ($task->stage == 'backlog')
			  					<span class="note yellow" id="{{ $task->id }}"><img class="img-circle img-responsive media-object pull-right" style="width:20px;" src="{{ $task->user->avatar }}"><a href="#" data-toggle="modal" data-target="#TaskModal{{$task->id}}">{{ str_limit($task->name, 30) }}</a></span>
			  					<div id="TaskModal{{$task->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="TaskLabel" aria-hidden="true" style="display: none;">
									<div class="modal-dialog">
										<div class="modal-content"  style="background: #eae672;">
											<div class="modal-header" style="border-bottom: 0px;">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
											</div>
											<div class="modal-body">
												<form method="POST" action="/task/{{ $task->id }}/update" role="form">
													{{ csrf_field() }}
													<div class="form-group">
														<label for="taskName">Name</label>
														<input type="text" class="form-control" id="taskName" name="taskName" placeholder="Enter task name" required value="{{ $task->name }}">
													</div>
													<div class="form-group">
														<label for="taskResponsible">Responsible</label>
														<select class="form-control" id="taskResponsible" name="taskResponsible">
															@foreach ($allusers as $us)
																@if ($us->id == $task->responsible)
																	<option value="{{ $us->id }}" SELECTED>{{ $us->name }}</option>
																@else
																	<option value="{{ $us->id }}">{{ $us->name }}</option>
																@endif
											  					
											  				@endforeach
														</select>
													</div>
													<div class="form-group">
														<label for="taskDesc">Description</label>
														<textarea class="form-control" rows="3" id="taskDesc" name="taskDesc" > {{ $task->desc }}</textarea>
													</div>
													<div class="form-group">
														<button type="submit" class="btn btn-default">Save</button>
														<p class="pull-right"><a href="/task/{{ $task->id }}/delete"><span class="glyphicon glyphicon-trash" aria-hidden="true" style="top:10px;"></span></a></p>
													</div>
												</form>
											</div>
							        </div><!-- /.modal-content -->
							      </div><!-- /.modal-dialog -->
							    </div>
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
		  					<span class="note yellow" id="{{ $task->id }}"><img class="img-circle img-responsive media-object pull-right" style="width:20px;" src="{{ $task->user->avatar }}">  {{ str_limit($task->name, 30) }}</span>
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
		  					<span class="note yellow" id="{{ $task->id }}"><img class="img-circle img-responsive media-object pull-right" style="width:20px;" src="{{ $task->user->avatar }}">  {{ str_limit($task->name, 30) }}</span>
		  				@endif
		  			@endforeach
	  			</div>
	  		</div>
		</div>	<!-- / panel -->
	</div> <!-- / col-md-4 -->
	
</div> <!-- / row -->

<script src='/js/dragula.js'></script>
<script src="/js/dropzone.js"></script>
<!--script src="/js/sweetalert.min.js"></script-->
<script>

/* Drag & drop script */
function $(id) {
  return document.getElementById(id);
}

dragula([$('backlog'), $('ongoing'), $('done')], {
  revertOnSpill: true
}).on('drop', function(el, target, source, sibling) {
  
  	var target = target.id;
	var taskid = el.id;
  	

  	// update state for this task
  	updateTask(target, taskid);

	return;
});

function updateTask(target, taskid) {
    
    var token = $('meta[name=csrf-token]').attr("content");

    $.ajax({

    	type: 'POST',
    	url: '/ajax/tasks/' + taskid,
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
	/* Sweet alert
	swal({   
		title: "Error!",   
		text: "Here's my error message!",   
		type: "error",   
		confirmButtonText: "Cool" 
	});
	*/

	/* Initial tooltip 
	$(function () {
	  $('[data-toggle="tooltip"]').tooltip()
	});
	*/
</script>

@stop