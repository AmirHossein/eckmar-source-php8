@extends('master.main')

@section('main-content')
<ol class="breadcrumb">
  <li><a href="{{route('home')}}">Home</a></li>
  <li><a href="{{route('showcat',['cslug'=>$cslug])}}">{{$product->category->name}}</a></li>
  <li class="active">{{$product->name}}</li>
</ol>
<div class="col-md-2">
  @include('master.sidebar')
</div>
<div class="col-md-8  m-t-25">

<div class="panel panel-default">
    <div class="panel-heading">
      {{$product->name}}
    </div>
    <div class="panel-body">
      <div class="row">
        <div class="col-md-4">
          @if($product->image !== null)
          <img src="{{url($product->image)}}" alt="" class="img-responsive" height="150px" width="150px"><br>
          @else
          <img src="{!! asset('img/No_image_available.svg')!!}" alt="" class="img-responsive" height="150px" width="150px"><br>
          @endif
        </div>
        <div class="col-md-4">
          <span>Sold by: {{$product->seller->username}}</span><br>
          <span>Trust rating: {{$product->seller->trustRating()}}</span><br>
          <span>Feedback score:</span><span>{{$product->seller->feedbackScore()}}</span><br>
          <a href="{{route('sendmessage',['username'=>$product->seller->username])}}">Send Message to {{$product->seller->username}}</a><br>
          <a href="{{route('viewprofile',['uniqueid'=>$product->seller->uniqueid])}}">View {{$product->seller->username}}'s profile</a>
        </div>
        <div class="col-md-4 ">


          @if($product->auction == true)
          <span>Auction is ending on: </span><br>
          <span class="font-weight-600">{{$product->end_date}}</span>
          @if($a_ends !== null)
          <br><span class="font-size-11">{{$a_ends}} from now</span>
          @endif
          <a href="{{route('showbid',['uniqueid'=>$product->uniqueid,'cslug'=>$cslug])}}" class="btn btn-default btn-lg btn-block m-t-10">Bid at least @if($product->bids->count() > 0){{number_format($product->bids->max('value')*0.00000001, 4, '.', ',')}} @else {{number_format($product->price*0.00000001, 4, '.', ',')}} @endif<span class="glyphicon glyphicon-bitcoin" aria-hidden="true"></span></a>
          <a href="{{route('showbuy',['uniqueid'=>$product->uniqueid,'cslug'=>$cslug])}}" class="btn btn-primary btn-lg btn-block">Buy now for {{number_format($product->buyout*0.00000001, 4, '.', ',')}} <span class="glyphicon glyphicon-bitcoin" aria-hidden="true"></span></a>
          @else
          <a href="{{route('showbuy',['uniqueid'=>$product->uniqueid,'cslug'=>$cslug])}}" class="btn btn-primary btn-lg btn-block">Buy now for {{number_format($product->price*0.00000001, 4, '.', ',')}} <span class="glyphicon glyphicon-bitcoin" aria-hidden="true"></span></a>
          @endif
          <div class="m-t-5">
            <center>
                <span class="font-size-12">You are protected by <span class="font-weight-600">escrow</span> <span class="glyphicon glyphicon-ok-circle" aria-hidden="true"></span></span>
            </center>
          </div>

        </div>
      </div>
  <div class="row margin-top-25 ">
    <ul class="nav nav-tabs">
    <li role="presentation" @if($item == 'description')class="active"@endif><a href="{{route('viewproduct',['cslug'=>$cslug,'uniqueid'=>$product->uniqueid])}}">Product Description</a></li>
    <li role="presentation" @if($item == 'refund_policy')class="active"@endif><a href="{{route('viewproduct',['cslug'=>$cslug,'uniqueid'=>$product->uniqueid,'item'=>'refund_policy'])}}">Refund Policy</a></li>
    <li role="presentation" @if($item == 'feedback')class="active"@endif><a href="{{route('viewproduct',['cslug'=>$cslug,'uniqueid'=>$product->uniqueid,'item'=>'feedback'])}}">Seller's Feedback</a></li>
    </ul>
  </div>
    <div class="margin-top-25">
    @if($item == 'description')
    <span>{{$product->description}}</span>

    @elseif($item == 'refund_policy')
    <span>@if($product->refund_policy == null)No refund policy @else {{$product->refund_policy}} @endif</span>

    @elseif($item == 'feedback')
    <div class="margin-top-25 margin-bottom-15">
    <center>
      <span>Current feedback score: {{$product->seller->feedbackScore()}}</span><br>
      <span>Trust rating: {{$product->seller->trustRating()}}</span>
    <div class="row">
      <div class="col-md-4 col-md-offset-4">
        <div class="progress">
        <div class="progress-bar @if($product->seller->feedbackScore() < 25 || $product->seller->trustRating() == 'Unproven') progress-bar-danger @elseif($product->seller->feedbackScore() < 50) progress-bar-warning @elseif($product->seller->feedbackScore() < 70) progress-bar-info @else progress-bar-success @endif" role="progressbar"  aria-valuemin="0" aria-valuemax="100" style="width: {{$product->seller->feedbackScore()}}%;">
          <span  @if($product->seller->feedbackScore() < 25) style="color:#000" @endif>{{$product->seller->trustRating()}}</span>
        </div>
      </div>
      </div>
    </div>
    <span>Feedback from buyers:</span><br>
    <table class="table table-hover">
      <thead>
        <th>From</th>
        <th>Type</th>
        <th>Comment</th>
        <th>Time</th>
      </thead>

      <tbody>
    @foreach($product->seller->feedback as $fd)
      @if($fd->for == $fd->seller_id && $fd->active == true)
      <tr>
        <td>{{$fd->buyer->username}}</td>
        <td>@if($fd->positive == true) <span class="label label-success">Positive</span>@else <span class="label label-danger"> Negative</span> @endif</td>
        <td>{{str_limit($fd->comment, $limit = 40, $end = '...') }}</td>
        <td>{{$fd->created_at}}</td>
      </tr>
      @endif
    @endforeach
      </tbody>
    </table>
    </center>
    </div>
    @endif
    </div>
    </div>
    <!-- end of panel body -->
</div>
</div>



@stop
