@extends('layout')

@section('content')

<div class="row">
<p class="pull-right"><a href="project/create" type="button" class="btn btn-default">Add project</a></p>
</div>


<div class="row">
    @foreach ($projects as $project)
    <div class="col-md-3"> 
        <div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title">{{ $project->name }}</h3>
            </div>
            <div class="panel-body" style="background-image: url(/img/wolf.jpg); min-height: 150px;">
                <br /><br /><br /><br /><br /><br /><br />
                <a class="pull-right" style="color: #f5f5f5;" href="project/{{ $project->id }}"><span class="glyphicon glyphicon-zoom-in"></span> open</a>
            </div>
          </div>
    </div>
    @endforeach
</div>
    

@stop