<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        @yield('css')
    </head>
    <body>
        <nav class="navbar navbar-inverse navbar-fixed-top">
          <div class="container">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="#">{{ config('app.name') }}</a>
            </div>
            <div id="navbar" class="collapse navbar-collapse">
              <ul class="nav navbar-nav">
                <li {{{ (Request::is('/') ? 'class=active' : '') }}}><a href="{{ url('/') }}">Home</a></li>
                <li {{{ (Request::is('teams') ? 'class=active' : '') }}}><a href="{{ url('/teams') }}">Teams</a></li>
                <li {{{ (Request::is('matches') ? 'class=active' : '') }}}><a href="{{ url('/matches') }}">Matches</a></li>
              </ul>
            </div><!--/.nav-collapse -->
          </div>
        </nav>

        <div class="container" style="padding-top: 48px;">
            @yield('content')
        </div>

        <footer>
            Copyright &copy; <time datetime="{{date('Y')}}">{{date('Y')}}</time>
        </footer>
    </body>
</html>
