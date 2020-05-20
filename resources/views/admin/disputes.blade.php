@extends('admin.master')

@section('content')
<table class="table table-hover">
    <thead>
      <th>UniqueID</th>
      <th>Purchase</th>
      <th>Seller</th>
      <th>Buyer</th>
      <th>Value</th>
      <th>Resolved</th>
      <th>Action</th>
    </thead>
    <tbody>
      @foreach($disputes as $d)
        <tr>
          <td>{{$d->uniqueid}}</td>
          <td>{{$d->purchase->product->name}}</td>
          <td>{{$d->seller->username}}</td>
          <td>{{$d->buyer->username}}</td>
          <td>{{$d->purchase->value*0.00000001}}</td>
          <td>@if($d->resolved == false)<span class="label label-danger">No</span>@else @if($d->winner == 1 ) <span class="label label-success">Seller Won</span> @else<span class="label label-success">Buyer Won</span> @endif @endif</td>
          <td><a href="{{route('dispute',['uniqueid'=>$d->uniqueid])}}">View</a></td>
        </tr>
      @endforeach
    </tbody>
</table>
<div class="m-t-25">
<center>
  {{$disputes->links()}}
</center>
</div>
@stop
