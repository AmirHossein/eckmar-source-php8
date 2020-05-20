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
      @foreach($purchases as $purchase)
        <tr>
          <td>{{str_limit($purchase->product->name, $limit = 25, $end = '...')}} @if($purchase->product->auction == true) <span class="label label-info">Auction</span>@endif</td>
          @if($purchase->product->image !== null)
          <td><img class="img-rounded" src="{{url($purchase->product->image)}}" alt="" height="25px" width="25px"></td>
          @else
          <td>No image</td>
          @endif
          <td>{{number_format($purchase->value*0.00000001, 6, '.', ',')}}</td>
          <td>{{$purchase->product->category->name}}</td>
          <td>@if($purchase->state == 0) <span class="label label-info">Processing</span> @elseif($purchase->state == 1) <span class="label label-primary">Delivered</span> @elseif($purchase->state == 2) <span class="label label-success">Completed</span> @elseif($purchase->state == 3)<span class="label label-warning">Disputed</span> @elseif($purchase->state == 4)<span class="label label-success">Refunded</span> @endif</td>
          <td>{{$purchase->created_at}}</td>
          <td><a href="@if($purchase->state !== 0){{route('goods',['uid'=>$purchase->uniqueid])}}@endif" class="btn btn-primary"  @if($purchase->state == 0) disabled @endif>Goods</a> @if($purchase->state == 2 || $purchase->state == 4)@if($purchase->feedback == null)<a href="{{URL::route('newfeedback', array('uniqueid' => $purchase->uniqueid,'u'=>'seller' ))}}" class="btn btn-success">Leave Feedback</a> @endif @elseif($purchase->dispute !== null) <a href="{{route('dispute',['uniqueid'=>$purchase->dispute->uniqueid])}}" class="btn btn-warning">Dispute</a> @endif</td>
        </tr>
      @endforeach
    </tbody>
</table>
<div class="m-t-25">
<center>
{{$purchases->links()}}
</center>
</div>
@stop
