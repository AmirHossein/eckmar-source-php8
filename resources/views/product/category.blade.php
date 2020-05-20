@extends('master.main')
<style media="screen">
.product{
  color:#333;
}
  .product:hover{
    color:#333;
  }
</style>
@section('main-content')
<ol class="breadcrumb">
  <li><a href="{{route('home')}}">Home</a></li>
  <li><a href="{{route('showcat',['cslug'=>$cslug])}}">{{$category->name}}</a></li>
</ol>
<div class="col-md-2">
  @include('master.sidebar')
</div>
<div class="col-md-10 m-t-25">
<div class="list-group">
  @foreach($products as $product)
  <a href="{{route('viewproduct',['cslug'=>$cslug,'uniqueid'=>$product->uniqueid])}}" class="product">
  <div class="panel panel-default">
    <div class="panel-body">
        <div class="col-md-2 pull-left ">
          @if($product->image !== null)
          <img src="{{url($product->image)}}" alt="" height="100px" width="100px">
          @else
          <img src="{!! asset('img/No_image_available.svg')!!}" alt="" height="100px" width="100px">
          @endif
      </div>
      <div class="m-l-50 col-md-7 ">
          <span class="font-size-24 " style="vertical-align:top">{{$product->name}}</span><br>
          <span>Sold by: {{$product->seller->username}}</span><br>
          <span>{{ str_limit($product->description, $limit = 120, $end = '...') }}</span><br>
          @if($product->auction == true)
          <span class="font-size-12"> <span class="glyphicon glyphicon-time" aria-hidden="true"></span>Aucion ends: {{$product->end_date}}</span>
          @endif

      </div>
      <div class="col-md-3 pull-right " >
        <center>
          @if($product->auction == true)
          <a href="{{route('viewproduct',['cslug'=>$cslug,'uniqueid'=>$product->uniqueid])}}" class="btn btn-primary" role="button" >Buy now for {{number_format($product->buyout*0.00000001, 2, '.', ',')}} <span class="glyphicon glyphicon-bitcoin" aria-hidden="true"></span></a>
         <br><a href="{{route('viewproduct',['cslug'=>$cslug,'uniqueid'=>$product->uniqueid])}}" class="btn btn-default m-t-10" role="button">Bid</a><br><br>
         <span>{{$product->bids->count()}} bids currently</span>

          @else
          <a href="{{route('viewproduct',['cslug'=>$cslug,'uniqueid'=>$product->uniqueid])}}" class="btn btn-primary" role="button" >Buy for {{$product->price*0.00000001}} <span class="glyphicon glyphicon-bitcoin" aria-hidden="true"></span></a>
          @endif
       </center>
      </div>

    </div>
  </div>
  </a>
  @endforeach
</div>

<!-- REF -->

</div>
<div class="row">
  <center>
    {{$products->links()}}
  </center>
</div>
@stop
