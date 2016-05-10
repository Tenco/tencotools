<span class="note yellow" id="{{ $task->id }}" style="height:55px;">
	<a href="#" data-toggle="modal" data-target="#TaskModal{{$task->id}}"><small data-toggle="tooltip" data-placement="top" data-container="body" title="{{ $task->name }}" >{{ str_limit($task->name, 13) }}</small></a><br />
	<img class="img-circle img-responsive media-object pull-right" style="width:20px; margin-left:3px;" src="{{ $task->user->avatar }}">
	@if ($task->blockedby)
		<span class="glyphicon glyphicon-ban-circle pull-right" data-toggle="tooltip" data-placement="top" data-blocker="{{ $task->blockedby }}" data-container="body" title="Task blocked by task #{{ $task->blockedby }}" style="color:#D31717; margin-left:3px;" aria-hidden="true"></span>
	@endif
	@if (isset($task->deadline))
		<span class="glyphicon glyphicon-calendar pull-right" data-toggle="tooltip" data-placement="top" data-container="body" title="{{ $task->deadline->diffForHumans() }}" style="margin-left:3px;"></span>
	@endif	
</span>
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
						@if (isset($task->blockedby))
							<div class="alert alert-danger" id="blockinfo{{ $task->id }}">
								<span class="glyphicon glyphicon-ban-circle"></span> Task blocked by task <a href="/project/{{$project->id}}#TaskModal{{$task->blockedby}}" target=_new>#{{ $task->blockedby }}</a>
								<a href="/removeblock/{{ $project->id }}/{{ $task->id }}" id="removeblock" class="pull-right"><small>remove</small></a>
							</div>
						@endif
						<div class="form-group">
							<label for="taskName">Name</label>
							<input type="text" class="form-control" id="taskName" name="taskName" placeholder="Enter task name" required value="{{ $task->name }}">
						</div>
						<div class="form-group">
							<label for="taskDesc">Description</label>
							<textarea class="form-control" rows="5" id="taskDesc" name="taskDesc" >{{ $task->desc }}</textarea>
						</div>
						<!-- MORE -->
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
							@if (isset($task->blockedby) || $task->blockedby === 0)
								<input type="hidden" name="blockedby" class="blockedby" value="{{ $task->blockedby }}">
							@else
								<label for="taskDeadline">Blocked by</label>
								<input type="text" class="form-control autocomplete" name="taskBlock" placeholder="Search for a task">
								<input type="hidden" name="blockedby" class="blockedby" value="">
							@endif
						</div>
						@if (isset($task->deadline))
							<div class="form-group" id="newDeadline">
								<label for="taskDeadline">Deadline ({{ $task->deadline->diffForHumans() }})</label>
								<input type="date" class="form-control" id="taskDeadline" name="taskDeadline" value="{{ date('Y-m-d',strtotime($task->deadline)) }}">
							</div>
						@else
							<div class="form-group" id="deadline">
								<label for="taskDeadline">Deadline</label>
								<input type="date" class="form-control" id="taskDeadline" name="taskDeadline" placeholder="yyyy-mm-dd" required>
							</div>
						@endif
						<div class="form-group" id="deadline">
								<label for="taskDeadline">Perma link:</label>
								<input type="text" class="form-control" value="{{ url('/project') . '/' .$project->id . '#TaskModal' . $task->id }}">
							</div>
						<div class="form-group">
							<!--div class="alert alert-success" style="display:none;" id="tasksuccess" role="alert">Task successfully updated</div-->
							<a href="/task/{{ $task->id }}/delete"><span class="glyphicon glyphicon-trash" style="top:10px;" data-toggle="tooltip" data-placement="top" title="Delete this task"></span></a>
							<p class="pull-right"><button type="submit" id="updateTask" class="btn btn-default">Save</button></p>
						</div>
					</form>
				</div>
	        </div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div>