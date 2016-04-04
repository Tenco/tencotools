@extends('layout')

@section('content')


<!-- NEW TASK MODAL -->
<div class="row">
	<div id="newTaskModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="newTaskLabel" aria-hidden="true" style="display: none;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title" id="newTaskLabel">New task</h4>
				</div>
				<div class="modal-body">
					<form method="POST" action="/project/{{ $project->id }}/tasks" role="form">
						{{ csrf_field() }}
						<div class="form-group">
							<label for="taskName">Name</label>
							<input type="text" class="form-control" id="taskName" name="taskName" placeholder="Enter task name" required value="{{ old('taskName') }}">
						</div>
						<div class="form-group">
							<label for="taskDesc">Description</label>
							<textarea class="form-control" rows="3" id="taskDesc" name="taskDesc" required>{{ old('taskDesc') }}</textarea>
						</div>
						<button type="submit" class="btn btn-default">Submit</button>
					</form>
				</div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div>
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
  		<a class="pull-left" href="#">
    		<img class="img-circle img-responsive media-object" src="/img/wolf.jpg">
  		</a>
  		<div class="media-body">
    		<h4 class="media-heading">{{ $project->name }}</h4>
    		<em>{{ $project->desc }}</em>
    		<hr />
    		<p class="pull-right">
    			<span class="glyphicon glyphicon-user"></span> {{ $project->user->name }} &nbsp;&nbsp;
	    		<span class="glyphicon glyphicon-calendar"></span> deadline 2016-07-01 &nbsp;&nbsp;
	    		<span class="glyphicon glyphicon-stats"></span> 45% compleated &nbsp;&nbsp;
	    		<a href="project/{{ $project->id }}/edit" data-toggle="modal" data-target="#editProjectModal" data-remote="false"><span class="glyphicon glyphicon-edit"></span> edit</a>  &nbsp;&nbsp;
	    		<span class="glyphicon glyphicon-trash"></span> delete
    		</p>
  		</div>
	</div>
</div>

@include('partials.error')

<div class="row">
	<div class="col-md-4"> 
		<div class="panel panel-primary">
			<div class="panel-heading">
	    		<h3 class="panel-title">Backlog<button data-toggle="modal" data-target="#newTaskModal" type="button" class="btn btn-default btn-xs pull-right"><span class="glyphicon glyphicon-plus" style="opacity: .5;"></span></button></h3>
	  		</div>
	  		<div class="panel-body">
	    		<div id="backlog" class="dropzone">
		  			@foreach ($project->tasks as $task)
		  				@if ($task->stage == 'backlog')
		  					<span class="note yellow" id="{{ $task->id }}"><!--span class="glyphicon glyphicon-fire"></span--> {{ $task->name }}</span>
		  				@endif
		  			@endforeach
	  			</div>
	  		</div>
		</div>	<!-- / panel -->
	</div> <!-- / col-md-4 -->

	<div class="col-md-4"> 
		<div class="panel panel-primary">
			<div class="panel-heading">
	    		<h3 class="panel-title">Ongoing</h3>
	  		</div>
	  		<div class="panel-body">
	    		<div id="ongoing" class="dropzone">
		  			@foreach ($project->tasks as $task)
		  				@if ($task->stage == 'ongoing')
		  					<span class="note yellow" id="{{ $task->id }}"><!--span class="glyphicon glyphicon-fire"></span--> {{ $task->name }}</span>
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
	    		<div id="done" class="dropzone">
		  			@foreach ($project->tasks as $task)
		  				@if ($task->stage == 'done')
		  					<span class="note yellow" id="{{ $task->id }}"><!--span class="glyphicon glyphicon-fire"></span--> {{ $task->name }}</span>
		  				@endif
		  			@endforeach
	  			</div>
	  		</div>
		</div>	<!-- / panel -->
	</div> <!-- / col-md-4 -->
	
</div> <!-- / row -->

<script src='http://rawgit.com/bevacqua/dragula/master/dist/dragula.js'></script>
<script>

/* Drag & drop script */
function $(id) {
  return document.getElementById(id);
}

dragula([$('backlog'), $('ongoing'), $('done')], {
  revertOnSpill: true
}).on('drop', function(el,target, source, sibling) {
  
	var taskid = el.id;
  	//alert(taskid);
	return;
});


</script>


@stop