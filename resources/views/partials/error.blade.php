@if (count($errors))

	<div class="alert alert-danger">
		<strong><span class="glyphicon glyphicon-warning-sign"></span> Error</strong>, please have a look at the following issues:
		<ul>
			@foreach ($errors->all() as $error)

				<li>{{ $error }}

			@endforeach
		</ul>
	</div>
	
@endif