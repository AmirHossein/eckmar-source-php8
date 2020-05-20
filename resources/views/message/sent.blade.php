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
      <li role="presentation" ><a href="{{route('messages')}}">Received</a></li>
      <li role="presentation" class="active"><a href="{{route('messagessent')}}">Sent</a></li>
      </ul>
    </div>
    <table  class="table table-hover">
      <thead>
        <th>To</th>
        <th>Title</th>
        <th>Time</th>
        <th>Action</th>
      </thead>
      <tbody>
        @foreach($sent as $s)
        <tr>
          <td>{{$s->To->username}}</td>
          <td>{{str_limit($s->title, $limit = 20, $end = '...') }}</td>
          <td>{{$s->created_at}}</td>
            <td><a href="{{route('viewmessage',['uniqueid'=>$s->uniqueid])}}" class="btn btn-default">Open</a></td>
        </tr>
        @endforeach
      </tbody>
    </table>
    <div class="form-group">
      <center>
        {{$sent->links()}}
      </center>
    </div>

  @endcomponent

@stop
