@extends('admin.master')

@section('content')
<div class="col-md-6 col-md-offset-3 m-t-50">
  @if(session()->has('errormessage'))
  <div class="alert alert-danger">
    <strong>Whoops ! </strong><span>{{session()->get('errormessage')}}</span>
  </div>
  @endif

<form class="" action="{{route('createcategorypost')}}" method="post">

  <div class="form-group">
    <label for="cname">Category name:</label>
    <input type="text" name="cname" value="" placeholder="Category Name" id="cname" class="form-control">
  </div>
  <div class="form-group">
    <center>
      <button type="submit" name="button" class="btn btn-success">Create Category</button>
    </center>
  </div>
{{csrf_field()}}
</form>
</div>
@stop
