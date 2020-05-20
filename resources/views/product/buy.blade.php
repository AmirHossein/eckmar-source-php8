@extends('master.main')

@section('main-content')
<ol class="breadcrumb">
  <li><a href="{{route('home')}}">Home</a></li>
  <li><a href="{{route('showcat',['cslug'=>$cslug])}}">{{$product->category->name}}</a></li>
  <li class="active">{{$product->name}}</li>
</ol>
  @component('master.notification')
    @slot('title')
      Buy  <span class="font-weight-600">{{$product->name}}</span>
    @endslot

        @if(session()->has('errormessage'))
        <div class="alert alert-danger">
          <strong>Whoops ! </strong><span>{{session()->get('errormessage')}}</span>
        </div>
        @endif
        @if(session()->has('successmessage'))
        <div class="alert alert-success">
          <strong>Whoops ! </strong><span>{{session()->get('successmessage')}}</span>
        </div>
        @endif
          <div class="form-group">
            <span>You are about to pay @if($product->auction == true){{$product->buyout*0.00000001}} @else {{$product->price*0.00000001}} @endif<span class="glyphicon glyphicon-bitcoin" aria-hidden="true"></span> for <strong>{{$product->name}}</strong></span>
          </div>

            <form class="" action="{{route('postbuy',['uniqueid'=>$product->uniqueid,'cslug'=>$cslug])}}" method="post">

          <div class="form-group">
            <center>
              <button type="submit" name="button" class="btn btn-success">Confirm purchase</button>
              <a href="{{route('viewproduct',['uniqueid'=>$product->uniqueid,'cslug'=>$cslug])}}" class="btn btn-danger">Back to product</a>
            </center>
          </div>
          <div class="m-t-5">
            <center>
                <span class="font-size-12">You are protected by <span class="font-weight-600">escrow</span> <span class="glyphicon glyphicon-ok-circle" aria-hidden="true"></span></span>
            </center>
          </div>
          {{csrf_field()}}
                    </form>
  @endcomponent

@stop
