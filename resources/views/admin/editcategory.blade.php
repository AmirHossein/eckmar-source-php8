@extends('admin.master')

@section('content')
<div class="col-md-6 col-md-offset-3 m-t-50">
  @if(session()->has('errormessage'))
  <div class="alert alert-danger">
    <strong>Whoops ! </strong><span>{{session()->get('errormessage')}}</span>
  </div>
  @endif

<form class="" action="{{route('editcategorypost',['uniqueid'=>$category->uniqueid])}}" method="post">
<div class="form-group">
<label for="cname">Category Name</label>
<input type="text" id="cname"name="cname" value="{{$category->name}}" class="form-control">
</div>
<div class="form-group">
<label for="cslug">Category Slug</label>
<input type="text" id="cslug"name="cslug" value="{{$category->slug}}" class="form-control">
</div>
<div class="form-group">
<center>
  <button type="submit" name="button" class="btn btn-warning">Edit Category</button>
</center>
</div>

{{csrf_field()}}
</form>
</div>
@stop
