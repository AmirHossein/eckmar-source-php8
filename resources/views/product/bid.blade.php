@extends('master.main')

@section('main-content')
<ol class="breadcrumb">
  <li><a href="{{route('home')}}">Home</a></li>
  <li><a href="{{route('showcat',['cslug'=>$cslug])}}">{{$product->category->name}}</a></li>
  <li class="active">{{$product->name}}</li>
</ol>

  @component('master.notification')
    @slot('title')
      Bid on <span class="font-weight-600">{{$product->name}}</span>
    @endslot

        @if(session()->has('errormessage'))
        <div class="alert alert-danger">
          <strong>Whoops ! </strong><span>{{session()->get('errormessage')}}</span>
        </div>
        @endif
        @if(session()->has('successmessage'))
        <div class="alert alert-success">
          <strong>Yay ! </strong><span>{{session()->get('successmessage')}}</span>
        </div>
        @endif
          <div class="form-group">
            <span>Minimum amount that you have to bid is {{$minbid}} <span class="glyphicon glyphicon-bitcoin" aria-hidden="true"></span></span>
          </div>
          <form class="" action="{{route('postbid',['uniqueid'=>$product->uniqueid,'cslug'=>$cslug])}}" method="post">


          <div class="form-group">
            <label for="bid">Bid amount:</label>
            <input type="number" step="any" name="bid" value="" class="form-control">
          </div>

          <div class="form-group">
            <center>
              <button type="submit" name="button" class="btn btn-success">Confirm bid</button>
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
