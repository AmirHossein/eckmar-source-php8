<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>{{env('APP_TITLE')}}</title>
    <link rel="stylesheet" href="{!! asset('css/bootstrap3.css') !!}">
    <link rel="stylesheet" href="{!! asset('css/helpers.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('css/app.css') !!}">
  </head>
  <body>
    @if(env('APP_DEMO') == true)
    @include('master.demobar')
    @endif
    @include('master.navbar')
    <div class="container">
    @yield('main-content')
    </div>
  </body>
</html>
