@extends('master.main')


@section('main-content')
<ol class="breadcrumb">
  <li><a href="{{route('home')}}">Home</a></li>
  <li class="active">{{$user->username}}</li>
</ol>
<div class="form-group">
  <center>
    <a href="{{route('viewprofile',['uniqueid'=>$user->uniqueid])}}">Back to {{$user->username}}'s profile</a>
  </center>
</div>
<div class="col-md-8 col-md-offset-2">
  <div class="panel panel-default">
    <div class="panel-heading">
      {{$user->username}}'s store
    </div>
    <div class="panel-body">

      <table class="table table-hover">
          <thead>
            <th>Name</th>
            <th>Image</th>
            <th>Category</th>
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
                <td>{{$product->created_at}}</td>
                <td><a href="{{route('viewproduct',['cslug'=>$product->category->slug,'uniqueid'=>$product->uniqueid])}}">View</a></td>
              </tr>
            @endforeach
          </tbody>
      </table>
      <div class="m-t-25">
      <center>
      {{$products->links()}}
      </center>
      </div>



    </div>
  </div>
</div>
@stop
