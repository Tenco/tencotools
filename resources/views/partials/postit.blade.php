{{-- 
@if ($task->responsible === Auth::id())
	<span class="note yellow" id="{{ $task->id }}"><img class="img-circle img-responsive media-object pull-right" style="width:20px;" src="{{ $task->user->avatar }}"><a href="#" data-toggle="modal" data-target="#TaskModal{{$task->id}}">{{ str_limit($task->name, 30) }}</a></span>
@else
	<span class="note lightyellow" id="{{ $task->id }}"><img class="img-circle img-responsive media-object pull-right" style="width:20px;" src="{{ $task->user->avatar }}"><a href="#" data-toggle="modal" data-target="#TaskModal{{$task->id}}">{{ str_limit($task->name, 30) }}</a></span>
@endif
--}}
<span class="note yellow" id="{{ $task->id }}"><img class="img-circle img-responsive media-object pull-right" style="width:20px;" src="{{ $task->user->avatar }}">
	@if ($task->blockedby)
		<span class="glyphicon glyphicon-ban-circle" data-toggle="tooltip" data-placement="top" data-blocker="{{ $task->blockedby }}" title="Task blocked by #{{ $task->blockedby }}" style="color:#D31717;" aria-hidden="true"></span>

	@endif
	<a href="#" data-toggle="modal" data-target="#TaskModal{{$task->id}}">{{ str_limit($task->name, 30) }}</a></span>
	<div id="TaskModal{{$task->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="TaskLabel" aria-hidden="true" style="display: none;">
		<div class="modal-dialog">
			<div class="modal-content"  style="background: #eae672;">
				<div class="modal-header" style="border-bottom: 0px;">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				</div>
				<div class="modal-body">
					<form method="POST" name="taskForm{{ $task->id }}" action="/task/{{ $task->id }}/update" role="form">
						<input name="_method" type="hidden" value="PATCH">
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
							<textarea class="form-control" rows="3" id="taskDesc" name="taskDesc" >{{ $task->desc }}</textarea>
						</div>
						<div class="form-group">
							<label for="taskBlock">Waiting for</label>
							@if (isset($task->blockedby))
								Task <a href="/project/{{$project->id}}#TaskModal{{$task->blockedby}}" target=_new>#{{ $task->blockedby }}</a>&nbsp;&nbsp;&nbsp;<small><a href=/removeblock/{{ $project->id }}/{{ $task->id }}><span class="glyphicon glyphicon-trash"></span></a></small>
							@else
								<input type="text" class="form-control autocomplete" name="taskBlock" placeholder="Search for a task">
								<input type="hidden" name="blockedby" class="blockedby" value="">
							@endif
						</div>
						<div class="form-group">
							<label for="taskDeadline">Deadline</label>
							@if (isset($task->deadline))
								{{ $task->deadline->diffForHumans() }} <!--&nbsp;&nbsp;&nbsp;<small><a href=#>change</a></small-->
								<input type="hidden" name="taskDeadline" value="{{ $task->deadline }}">
							@else
								<input type="date" class="form-control" id="taskDeadline" name="taskDeadline" placeholder="Enter task deadline" value="{{ $task->deadline }}">
							@endif
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