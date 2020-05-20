@extends('master.main')

@section('main-content')

  @component('master.notification')
    @slot('size')
    col-md-8 col-md-offset-2
    @endslot
    @slot('title')
    Send new message
    @endslot
    @if(session()->has('errormessage'))
    <div class="alert alert-danger">
      <strong>Whoops ! </strong><span>{{session()->get('errormessage')}}</span>
    </div>
    @endif
    <form class="" action="{{route('sendmessagepost')}}" method="post">
      <div class="form-group">
        <label for="recipient">Recipient:</label>
        <input type="text" name="recipient" id="recipient" value="@if($recipient !== null){{$recipient->username}}@endif" class="form-control">
      </div>
      <div class="form-group">
        <label for="title">Title:</label>
        <input type="text" name="title" id="title" value="{{old('title')}}" class="form-control">
      </div>
      <div class="form-group">
        <label for="text">Text:</label>
        <textarea name="text" class="form-control" style="resize:none" rows="8" cols="80">{{old('text')}}</textarea>
      </div>
      <div class="form-group">
        <center>
          <button type="submit" name="button" class="btn btn-success">Send Message</button>
        </center>
      </div>
      {{csrf_field()}}
    </form>

  @endcomponent

@stop
