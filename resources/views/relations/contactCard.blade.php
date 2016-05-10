<p class="text-center"><img src="/img/relations/{{ $relation->img }}" style="max-height:250px;" class="img-thumbnail"></p>
<blockquote class="text-center">
	<p><h1><span class="glyphicon glyphicon-user"></span> {{ $relation->name }}</h1></p>
	<p><h3><span class="glyphicon glyphicon-home"></span> {{ $relation->company }}</h3></p>
	<p><h3><span class="glyphicon glyphicon-send"></span> <a href="mailto: {{ $relation->email }}">{{ $relation->email }}</a></h3></p>
	<p><h3><span class="glyphicon glyphicon-earphone"></span> <a href="tel: {{ $relation->phone }}">{{ $relation->phone }}</a></h3></p>
</blockquote>
<br /><br />
<p class="text-right"><a href="/relations/{{ $relation->id }}/edit"><span class="glyphicon glyphicon-cog"></span> edit</a><p>