@extends('master.main')


@section('main-content')
<ol class="breadcrumb">
  <li><a href="{{route('home')}}">Home</a></li>
</ol>
<div class="col-xs-2">
  @include('master.sidebar')
</div>
<div class="col-xs-8">
  @foreach($news as $n)
  <div class="panel panel-default">
    <div class="panel-body">
      <center>
        <h1>{{$n->title}}</h1>
        <p>{{$n->text}}</p>
      </center>
    </div>
  </div>
  @endforeach

  <div class="margin-top-25">
    <center>
      {{$news->links()}}
    </center>
  </div>
</div>
@stop
