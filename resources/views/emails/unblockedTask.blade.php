<!DOCTYPE html>
<html lang="en-US">
    <head>
    <meta charset="utf-8">
    <style>
.postit {
    background-image: url(http://tencotools.se/img/post-it.png);
    height: 255px;
    width: 273px;
    padding: 69px;
}

</style>
    </head>
    <body>
<div class="postit">
	<h2><a href="http://tencotools.se/project/{{ $project_id }}#TaskModal{{ $task_id }}">
        Taks #{{ $task_id }} is no longer blocked!
    </a></h2>
</div>
</body>
</html>