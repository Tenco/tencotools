@if (count($errors))

	<div class="alert alert-danger">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  			<span aria-hidden="true">&times;</span>
		</button>
		<strong><span class="glyphicon glyphicon-warning-sign"></span> Error</strong>, please have a look at the following issues:
		<ul>
			@foreach ($errors->all() as $error)

				<li>{{ $error }}

			@endforeach
		</ul>
	</div>
	
@endif