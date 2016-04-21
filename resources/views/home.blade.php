@extends('layout')

@section('content')

@include('partials.msg')

<div class="row">
  <div class="col-md-12"> 
    <p class="pull-right"><a href="project/create" type="button" class="btn btn-default">Add project</a></p>
  </div>
</div>

<div>

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Ongoing Projects</a></li>
    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Archived projects</a></li>
    
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="home">
        <div class="row" style="margin-top:20px;">
            @foreach ($projects as $project)
                @if (is_null($project->close_date))
                    <div class="col-md-3"> 
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                              <h3 class="panel-title">{{ str_limit($project->name, 30) }}</h3>
                            </div>

                          @if (isset($project->img))
                            <div class="panel-body" style="background-image: url(/img/projectuploads/{{ $project->img }}); background-size: cover;">
                                <br /><br /><br /><br /><br /><br /><br />
                                <a class="pull-right" style="color: #f5f5f5;" href="project/{{ $project->id }}"><span class="glyphicon glyphicon-zoom-in"></span> open</a>
                            </div>
                          @else
                            <div class="panel-body" style="background-image: url('/img/default_project_image.jpg'); min-height: 150px;">
                                <br /><br /><br /><br /><br /><br /><br />
                                <a class="pull-right" style="color: #f5f5f5;" href="project/{{ $project->id }}"><span class="glyphicon glyphicon-zoom-in"></span> open</a>
                            </div>
                          @endif

                            
                          </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
    
    <div role="tabpanel" class="tab-pane" id="profile">
        <div class="row" style="margin-top:20px;">
            @foreach ($projects as $project)
                @if (isset($project->close_date))
                    <div class="col-md-3"> 
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                              <h3 class="panel-title">{{ $project->name }}</h3>
                            </div>
                            <div class="panel-body" style="background-image: url(/img/projectuploads/{{ $project->img }}); min-height: 150px;">
                                <br /><br /><br /><br /><br /><br /><br />
                                <a class="pull-right" style="color: #f5f5f5;" href="/project/{{ $project->id }}"><span class="glyphicon glyphicon-zoom-in"></span> open</a>
                            </div>
                          </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
  </div>

</div>


    

@stop