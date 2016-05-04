
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="Tenco">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <link rel="icon" href="../../favicon.ico">

    <title>Tenco Tools</title>

    <!-- styles for this template -->
    <link href="/css/all.css" rel="stylesheet">

    <style>
      body {
        min-height: 2000px;
        padding-top: 70px;
      }

      .tooltip {
         position: fixed !important;
         z-index: 1;
      }
    </style>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    @include('partials.topNav')

    <div class="container">
      @yield('content')
      <!-- Main component for a primary marketing message or call to action -->

    </div> <!-- /container -->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/js/all.js"></script>
    <script src="/js/jquery.autocomplete.js"></script>

    
    @yield('scrips')
    <!-- 
    This code below will look at the URL and if it contains a 
    #hash it will try to pop corresponding modal window.
    -->
    <script>
        $(document).ready(function(){
          var hash = $(location).attr('hash');
          if (hash)
          {
            $(hash).modal('show');
          }
           


          /* AUTOMCOMPLETE BLOCK SEARCH */
          var countries = [
            <?php
              // loop out all the tasks for this project:
              if (isset($project))
              {
                foreach($project->tasks as $task)
                {
                  echo "{ value: '". $task->name ."', data: '". $task->id ."' },";
                }
              }
                

            ?>
          ];

          $('.autocomplete').autocomplete({
              lookup: countries,
              onSelect: function (suggestion) {
                
                // there are many forms
                // var formname = $(this).parents("form").attr("name");

                //alert('You selected: ' + suggestion.value + ', ' + suggestion.data);
                $('.blockedby').val(suggestion.data);
                
              }
          });


          
        }); // end document ready

  $(".glyphicon-ban-circle").hover(function() 
  {
      // get the data attribute
      blockid = $(this).data("blocker");
      $("#" + blockid)
      .animate({'left':(-5)+'px'},150)
      .animate({'left':(+10)+'px'},150)
      .animate({'left':(-5)+'px'},150);
  });
        // enable tooltips on all pages
        $(function () { $("[data-toggle='tooltip']").tooltip(); });

     
        // remove hash (e.g. #TaskModal180) from URL when closing modal
        // otherwise the modal will open on refresh even if closed by user
        $('.modal').on('hidden.bs.modal', function () {
          parent.location.hash = '';
        });

        $('.modal').on('shown.bs.modal', function () {
          $(this).find('input:text:visible:first').focus();
        });


    </script>
  </body>
</html>
