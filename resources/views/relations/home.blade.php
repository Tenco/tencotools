@extends('layout')

@section('content')

@include('partials.msg')

  <div class="row">
    <div class="col-md-12">
      
        <form class="form-inline pull-right">
          <div class="input-group">
            <input type="text" class="form-control" placeholder="Search for...">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button">
              <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Go</button>
            </span>
          </div><!-- /input-group -->
        </form>
        <!-- p class="pull-right"><a href="relation/create" type="button" class="btn btn-default">Add contact</a></p -->
    </div>
  </div>

    <div class="row" style="margin-top:20px;">
      <div class="col-sm-2"> 
          <div class="panel panel-primary" style="min-height: 150px;">
            <div class="panel-heading" style="background-color: #3AB733">
              <h3 class="panel-title">New Contact</h3>
            </div>
            <div class="panel-body" style="background-image: url(/img/relations.png); background-size: cover;">
              <br /><br /><br />
            <div class="row" style="background: rgba(14, 58, 78, 0.34); padding:10px;">
                <a class="pull-right" style="color: #f5f5f5;" href="relation/create"><span class="glyphicon glyphicon-plus"></span> Add</a>
            </div>
          </div>
        </div>
      </div>
      @for ($i=0;$i<=12;$i++)
        <div class="col-sm-2"> 
          <div class="panel panel-primary" style="min-height: 150px;">
            <div class="panel-heading">
              <h3 class="panel-title">Olle Bulle</h3>
            </div>
          <div class="panel-body" style="background-image: url(/img/relations.png); background-size: cover;">
            <br /><br /><br />
            <div class="row" style="background: rgba(14, 58, 78, 0.34); padding:10px;"><a class="pull-right" style="color: #f5f5f5;" href="#"><span class="glyphicon glyphicon-zoom-in"></span> open</a></div>
          </div>
        </div>
      </div>
    @endfor
  </div>

  <nav class="text-center">
    <ul class="pagination pagination-sm">
      <li class="disabled">
        <a href="#" aria-label="Previous">
          <span aria-hidden="true">&laquo;</span>
        </a>
      </li>
      <li class="active"><a href="#">1</a></li>
      <li><a href="#">2</a></li>
      <li><a href="#">3</a></li>
      <li><a href="#">4</a></li>
      <li><a href="#">5</a></li>
      <li>
        <a href="#" aria-label="Next">
          <span aria-hidden="true">&raquo;</span>
        </a>
      </li>
    </ul>
  </nav>

@stop