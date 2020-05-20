@extends('admin.master')

@section('content')
<div class="m-t-25 m-b-20">
<center>
  <a href="{{route('createcategory')}}" class="btn btn-primary">Create category</a>
</center>
</div>
<table class="table table-hover">
    <thead>
      <th>UniqueID</th>
      <th>Name</th>
      <th>Slug</th>
      <th>Action</th>
    </thead>
    <tbody>
      @foreach($categories as $category)
        <tr>
          <td>{{$category->uniqueid}}</td>
          <td>{{$category->name}}</td>
          <td>{{$category->slug}}</td>
          <td><a href="{{route('editcategory',['uniqueid'=>$category->uniqueid])}}">Edit</a></td>
        </tr>
      @endforeach
    </tbody>
</table>
@stop
