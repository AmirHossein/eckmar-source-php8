@extends('admin.master')

@section('content')
<div class="form-group margin-top-25">
  <center>
    <a href="{{route('newscreate')}}" class="btn btn-primary">Create New</a>
  </center>
</div>
<table class="table table-hover">
    <thead>
      <th>UniqueID</th>
      <th>Title</th>
      <th>Published At</th>
      <th>Action</th>
    </thead>
    <tbody>
      @foreach($news as $n)
        <tr>
          <td>{{$n->uniqueid}}</td>
          <td>{{str_limit($n->title, $limit = 30, $end = '...') }}</td>
          <td>{{$n->created_at}}</td>
          <td><a href="{{route('editnews',['uniqueid'=>$n->uniqueid])}}" class="btn btn-default">Edit</a></td>
        </tr>
      @endforeach
    </tbody>
</table>
<div class="m-t-25">
<center>
  {{$news->links()}}
</center>
</div>
@stop
