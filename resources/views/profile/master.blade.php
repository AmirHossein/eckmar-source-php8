@extends('master.main')

@section('main-content')
<div class="col-md-12 ">


<div class="panel panel-default">
  <div class="panel-heading">
    <a href="{{route('viewprofile',['uniqueid'=>Auth::user()->uniqueid])}}">{{Auth::user()->username}}</a>
  </div>
  <div class="panel-body">
    <div class="m-t-15 m-b-50">
    @include('profile.navigation')
    </div>
    @yield('content')
  </div>
</div>

</div>
@stop
