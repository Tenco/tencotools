@if(Session::has('flash_message'))
   	<div class="alert alert-success">
   		<span class="glyphicon glyphicon-ok"></span><em> {!! Session::get('flash_message') !!}</em>
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
   	</div>
@endif