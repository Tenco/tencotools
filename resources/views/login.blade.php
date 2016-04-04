<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="Tenco">
    <link rel="icon" href="../../favicon.ico">

    <title>Tenco Tools</title>

    <!-- styles for this template -->
    <link href="/css/all.css" rel="stylesheet">

    <style>
      body {
        min-height: 2000px;
        padding-top: 70px;
      }
    </style>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    

    <div class="container">
      
       @if(Session::has('error'))
        <div class="alert alert-danger">
          <strong><span class="glyphicon glyphicon-warning-sign"></span> Error</strong>{{ Session::get('error') }}
        </div>
      @endif
      
      Hej. <a href="/sociallogin">Logga in här</a>

    </div> <!-- /container -->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/js/all.js"></script>
  </body>
</html>
