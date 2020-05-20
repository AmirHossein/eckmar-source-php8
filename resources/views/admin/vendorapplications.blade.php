@extends('admin.master')

@section('content')
<table class="table table-hover">
    <thead>
      <th>UniqueID</th>
      <th>User</th>
      <th>Status</th>
      <th>Date</th>
      <th>Action</th>
    </thead>
    <tbody>
      @foreach($va as $v)
        <tr>
          <td>{{$v->uniqueid}}</td>
          <td>{{$v->user->username}}</td>
          <td>@if($v->status == 0)Unchecked @elseif($v->status == 1)Approved @elseif($v->status == 2)Denied @elseif($v->status == 3) Paid @else Udefined @endif</td>
          <td>{{$v->created_at}}</td>
          <td><a href="{{route('va',['uniqueid'=>$v->uniqueid])}}">Edit</a></td>
        </tr>
      @endforeach
    </tbody>
</table>
<div class="m-t-25">
<center>
  {{$va->links()}}
</center>
</div>
@stop
