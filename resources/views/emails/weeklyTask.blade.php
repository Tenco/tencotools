<!DOCTYPE html>
<html lang="en-US">
    <head>
    <meta charset="utf-8">

    </head>
    <body>
<div>
    @if (count($tasks) > 0)
    	<h2>{{ $namn }}, these are your upcoming deadlines for the week:</h2>
        <ul>
        @foreach ($tasks as $taskName => $link)
            <li><a href="{{ $link }}">{{ $taskName }}</a>
        @endforeach
        </ul>
    @else
        <h2>{{ $namn }}! You have no deadlines comming up this week..sweet :)</h2>
    @endif

</div>
</body>
</html>