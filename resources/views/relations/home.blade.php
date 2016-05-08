@extends('layout')

@section('content')

@include('partials.msg')


<!-- CONTACT CARD -->

  <div id="RelationsModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="RelationsModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header" style="border-bottom: 0px solid #FFFFFF;">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <!--h4 class="modal-title" id="newTaskLabel">Name of contact</h4-->
        </div>
        <div class="modal-body">
          contact card...
        </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div>


  <div class="row">
    <div class="col-md-12">
        
        <a href=# class="btn btn-default" type="button"><span class="glyphicon glyphicon-envelope"></span> Send out</a>
        <form class="form-inline pull-right">
          <div class="input-group">
            <input type="text" class="form-control" placeholder="Search for...">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button">
              <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Go</button>
            </span>
          </div><!-- /input-group -->
        </form>

    </div>
  </div>

    <div class="row" style="margin-top:20px;">
      <div class="col-sm-2"> 
          <div class="panel panel-primary" style="min-height: 150px;">
            <div class="panel-heading" style="background-color: #3AB733">
              <h3 class="panel-title" style="font-weight: 200;">New Contact</h3>
            </div>
            <div class="panel-body" style="background-image: url(/img/relations.png); background-size: cover;">
              <br /><br /><br />
            <div class="row" style="background: rgba(14, 58, 78, 0.34); padding:10px;">
                <a class="pull-right" style="color: #f5f5f5;" href="relations/create"><span class="glyphicon glyphicon-plus"></span> Add</a>
            </div>
          </div>
        </div>
      </div>
      @foreach ($relations as $contact)
        <div class="col-sm-2"> 
          <div class="panel panel-primary" style="min-height: 150px;">
            <div class="panel-heading">
              <h3 class="panel-title"  style="font-weight: 200;" data-toggle="tooltip" data-placement="top" title="Han som sjunger så bra och aldrig har skor">{{ $contact->name }}</h3>
            </div>
            <?php
              if (isset($contact->img))
              {
                $bg = '/img/relations/'.$contact->img;
              }
              else
              {
                $bg = '/img/relations.png';
              }
              ?>
          <div class="panel-body" style="background-image: url({{ $bg }}); background-size: cover;">
            <br /><br /><br />
            <div class="row" style="background: rgba(14, 58, 78, 0.34); padding:10px;"><!--a style="color: #f5f5f5;" href=#><span class="glyphicon glyphicon-comment"></span> <small>(23)</small></a-->

              <a class="pull-right" style="color: #f5f5f5;" href="/relation/{{ $contact->id }}" data-remote="false" data-toggle="modal" data-target="#RelationsModal"><span class="glyphicon glyphicon-zoom-in"></span> view</a></div>
    

          </div>
        </div>
      </div>
    @endforeach
  </div>

  <div class="text-center">{!! $relations->links() !!}</div>

@stop

@section('scripts')
  <script type="text/javascript">
  // Fill modal with content from link href
  $("#RelationsModal").on("show.bs.modal", function(e) {
      var link = $(e.relatedTarget);
      $(this).find(".modal-body").load(link.attr("href"));
  });
  </script>
@stop