@extends('master.main')

@section('main-content')
<div class="col-md-12">
@include('admin.navigation')

@yield('content')



</div>
@stop
