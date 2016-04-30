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
    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Projects</a></li>
    <li role="presentation"><a href="#tasks" aria-controls="tasks" role="tab" data-toggle="tab">My Tasks</a></li>
    <li role="presentation" class="pull-right"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Archived projects</a></li>
    
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
                            <?php
                            if (isset($project->img))
                            {
                              $bg = '/img/projectuploads/'.$project->img;
                            }
                            else
                            {
                              $bg = '/img/default_project_image.jpg';
                            }
                            ?>
                            <div class="panel-body" style="background-image: url({{ $bg }}); background-size: cover;">
                                <br /><br /><br /><br /><br /><br /><br />
                                <div class="row" style="background: rgba(14, 58, 78, 0.34); padding:10px;"><a class="pull-right" style="color: #f5f5f5;" href="project/{{ $project->id }}"><span class="glyphicon glyphicon-zoom-in"></span> open</a></div>
                            </div>
                           
                          </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
    
    <!-- Tab panes -->
      <div role="tabpanel" class="tab-pane" id="tasks">
          <div class="row" style="margin-top:20px;">
            <div class="col-md-12"> 
               <?php
                  $antal = 0;
                  $ongoing = [
                      'ongoing',
                      'ongoing_2',
                      'ongoing_3',
                  ];
                ?>
                @foreach ($projects as $project)
                    @if (is_null($project->close_date))
                      @foreach ($project->tasks as $task)
                        
                        
                        @if (in_array($task['stage'], $ongoing))
                           <span class="note yellow">
                        @else
                           <span class="note yellow" style="background: #DFF0D8;">
                        @endif
                        
                          @if (isset($task['deadline']) &&  $task['deadline'] < $now)
                            <span class="glyphicon glyphicon-warning-sign pull-right" data-toggle="tooltip" data-placement="top" title="Deadline was {{ $task['deadline']->diffForHumans() }}!!" style="margin-left:3px;"></span>
                          @endif 
                              <span class="glyphicon glyphicon-info-sign pull-right" data-toggle="tooltip" data-placement="top" title="Project: {{ $project->name }}" style="margin-left:3px;"></span>
                              <br /><a href="/project/{{ $project->id }}#TaskModal{{ $task['id']}}"><small>{{ str_limit($task['name'], 35) }}</small></a>
                          </span>
                          <?php
                            $antal++;
                          ?>
                        
                      @endforeach
                    @endif
                @endforeach

              @if ($antal == 0)
                    <h2>Y u no work?</h2>
                    <img src="/img/y-u-no.jpg" class="img-circle" style="max-width:150px;">
              @endif
              </div>
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