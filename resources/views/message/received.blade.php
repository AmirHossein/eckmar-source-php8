@extends('master.main')

@section('main-content')

  @component('master.notification')
    @slot('size')
    col-md-8 col-md-offset-2
    @endslot
    @slot('title')
    My messages
    @endslot
    <div class="row">
      <center>
        <a href="{{route('sendmessage')}}" class="btn btn-primary">Send new message</a>
      </center>
    </div>
    <div class="row">
      <ul class="nav nav-tabs">
      <li role="presentation" class="active"><a href="{{route('messages')}}">Received</a></li>
      <li role="presentation"><a href="{{route('messagessent')}}">Sent</a></li>
      </ul>
    </div>
    <table  class="table table-hover">
      <thead>
        <th>From</th>
        <th>Title</th>
        <th>Time</th>
        <th>Action</th>
      </thead>
      <tbody>
        @foreach($received as $r)
          <tr>
            <td>{{$r->From->username}} @if($r->viewed == false)<span class="label label-default">Not Viewed</span> @endif</td>
            <td>{{str_limit($r->title, $limit = 20, $end = '...') }}</td>
            <td>{{$r->created_at}}</td>
            <td><a href="{{route('viewmessage',['uniqueid'=>$r->uniqueid])}}" class="btn btn-default">Open</a></td>
          </tr>
        @endforeach
      </tbody>
    </table>
    <div class="form-group">
      <center>
        {{$received->links()}}
      </center>
    </div>

  @endcomponent

@stop
