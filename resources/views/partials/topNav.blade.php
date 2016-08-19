<!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a href="/" class="pull-left" ><img style="max-width:70px;margin-right:30px;margin-top:5px;" src="/img/tencologo_400_227.png"></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="{{ ! Request::segment(1) || Request::segment(1) === 'project' ? 'active' : null }}"><a href="/">Projects</a></li>
            <li class="{{ \Helpers\set_active('relations') }}"><a href="/relations">Relations</a></li>
            <li class="disabled"><a href="#">Templates</a></li>
            <li class="disabled"><a href="#">Events</a></li>
            


            <!--li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="#">Action</a></li>
                <li><a href="#">Another action</a></li>
                <li><a href="#">Something else here</a></li>
                <li role="separator" class="divider"></li>
                <li class="dropdown-header">Nav header</li>
                <li><a href="#">Separated link</a></li>
                <li><a href="#">One more separated link</a></li-->
              </ul>
            </li>
          </ul>

            <ul class="nav navbar-nav navbar-right">
            <li><a href="#" data-toggle="dropdown" class="dropdown-toggle"><span class="glyphicon glyphicon-user
"></span> {{ Auth::user()->name }} <b class="caret"></b></a>
              <ul class="dropdown-menu">
                  <!--li><a href="#">Action</a></li>
                  <li><a href="#">Another action</a></li>
                  <li class="divider"></li-->
                  <li><a href="/logout">Log out</a></li>
              </ul>
            </UL>
        

          <!--ul class="nav navbar-nav navbar-right">
            <li><a href="../navbar/">Default</a></li>
            <li><a href="../navbar-static-top/">Static top</a></li>
            <li><a href="/logout">Log out</a></li>
          </ul-->
        </div><!--/.nav-collapse -->
      </div>
    </nav>