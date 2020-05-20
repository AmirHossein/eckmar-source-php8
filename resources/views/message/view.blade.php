@extends('master.main')

@section('main-content')

  @component('master.notification')
    @slot('size')
    col-md-8 col-md-offset-2
    @endslot
    @slot('title')
    Message from <span class="font-weight-600">{{$message->From->username}}</span> sent to <span class="font-weight-600">{{$message->To->username}}</span>
    @endslot

      <div class="from-group">

      </div>
      <div class="form-group">
        <label for="title">Title:</label>
        <input type="text" name="title" id="title" value="{{$message->title}}" class="form-control" readonly="">
      </div>
      <div class="form-group">
        <label for="text">Text:</label>
        <textarea name="text" class="form-control" style="resize:none" rows="8" cols="80" readonly="">{{$message->text}}</textarea>
      </div>
      <div class="form-group">
        <center>
        @if(Auth::user()->id == $message->To->id)
        <a href="{{route('sendmessage',['username'=>$message->From->username])}}" class="btn btn-primary">Reply</a>
        @elseif(Auth::user()->id == $message->From->id)
          <a href="{{route('sendmessage',['username'=>$message->To->username])}}" class="btn btn-primary">Send another message to {{$message->To->username}}</a>
        @endif
        </center>
      </div>


  @endcomponent

@stop
