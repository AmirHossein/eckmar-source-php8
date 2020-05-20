@extends('profile.master')

@section('content')
<table class="table table-hover">
    <thead>
      <th>Name</th>
      <th>Image</th>
      <th>Value</th>
      <th>Category</th>
      <th>State</th>
      <th>Purchase Time</th>
      <th>Action</th>
    </thead>
    <tbody>
      @foreach($sales as $sale)
        <tr>
          <td>{{str_limit($sale->product->name, $limit = 25, $end = '...')}} @if($sale->product->auction == true) <span class="label label-info">Auction</span>@endif</td>
          @if($sale->product->image !== null)
          <td><img class="img-rounded" src="{{url($sale->product->image)}}" alt="" height="25px" width="25px"></td>
          @else
          <td>No image</td>
          @endif
          <td>{{number_format($sale->value*0.00000001, 6, '.', ',')}}</td>
          <td>{{$sale->product->category->name}}</td>
          <td>@if($sale->state == 0) <span class="label label-info">Processing</span> @elseif($sale->state == 1) <span class="label label-primary">Delivered</span> @elseif($sale->state == 2) <span class="label label-success">Completed</span> @elseif($sale->state == 3)<span class="label label-warning">Disputed</span> @elseif($sale->state == 4)<span class="label label-danger">Refunded</span> @endif</td>
          <td>{{$sale->created_at}}</td>
          <td>@if($sale->state == 0)<a href="{{route('deliver',['uid'=>$sale->uniqueid])}}" class="btn btn-success" > Deliver Goods</a> @else <a href="{{route('goods',['uid'=>$sale->uniqueid])}}" class="btn btn-primary" >Goods</a> @endif @if($sale->state == 2 || $sale->state == 4)@if($sale->feedback()->where('from',Auth::user()->id)->first() == null)<a href="{{URL::route('newfeedback', array('uniqueid' => $sale->uniqueid,'u'=>'buyer' ))}}" class="btn btn-success">Leave Feedback</a> @endif @elseif($sale->dispute !== null) <a href="{{route('dispute',['uniqueid'=>$sale->dispute->uniqueid])}}" class="btn btn-warning">Dispute</a>@endif</td>
        </tr>
      @endforeach
    </tbody>
</table>
<div class="m-t-25">
<center>
{{$sales->links()}}
</center>
</div>
@stop
