@extends('admin.master')

@section('content')
<div class="col-md-10 col-md-offset-1 m-t-25">
  @if(session()->has('errormessage'))
  <div class="alert alert-danger">
    <strong>Whoops ! </strong><span>{{session()->get('errormessage')}}</span>
  </div>
  @endif
<form class="" action="{{route('editnewspost',['uniqueid'=>$news->uniqueid])}}" method="post">
    <div class="form-group">
      <label for="title">Title:</label>
      <input type="text" name="title" id="title" value="{{$news->title}}" class="form-control">
    </div>
    <div class="form-group">
      <label for="text">Text:</label>
      <textarea name="text" rows="35" cols="80" class="form-control" style="resize:none">{{$news->text}}</textarea>
    </div>

    <div class="form-group">
      <center>
        <button type="submit" name="button" class="btn btn-warning">Edit</button>
      </center>
    </div>
    {{csrf_field()}}
</form>
</div>
@stop
