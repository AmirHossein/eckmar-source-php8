@extends('profile.master')

@section('content')
<table class="table table-hover">
    <thead>
      <th>Name</th>
      <th>Image</th>
      <th>Category</th>
      <th>Sold</th>
      <th>Creation Time</th>
      <th>Action</th>
    </thead>
    <tbody>
      @foreach($products as $product)
        <tr>
          <td>{{str_limit($product->name, $limit = 25, $end = '...')}} @if($product->auction == true) <span class="label label-info">Auction</span>@endif</td>
          @if($product->image !== null)
          <td><img class="img-rounded" src="{{url($product->image)}}" alt="" height="25px" width="25px"></td>
          @else
          <td>No image</td>
          @endif
          <td>{{$product->category->name}}</td>
          <td>@if($product->sold == false) <span class="label label-danger">No</span> @else <span class="label label-success">Yes</span>@endif</td>
          <td>{{$product->created_at}}</td>
          <td><a href="{{route('editproduct',['uniqueid'=>$product->uniqueid])}}" class="btn btn-default">Edit</a>@if($product->auction == false && $product->sold == false)@if($product->autofilled == false)<a href="{{route('autofill',['uniqueid'=>$product->uniqueid])}}" class="btn btn-default margin-left-5">Add Autofill</a> @else <a href="{{route('autofill',['uniqueid'=>$product->uniqueid])}}" class="btn btn-default margin-left-5">Edit Autofill</a> @endif @endif</td>
        </tr>
      @endforeach
    </tbody>
</table>
<div class="m-t-25">
<center>
{{$products->links()}}
</center>
</div>
@stop
