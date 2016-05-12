<table class="table table-condensed">
	<tr>
		<th>Filename</th>
		<th>Uploaded by</th>
		<th>Uploaded</th>
		<th></th>
	<tr>
	<tbody>
		@if ($files->isEmpty())
			<tr class="info"><td colspan=4>&nbsp;<em>No files uploaded</em></td></tr>
		@else
			@foreach ($files as $file)
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