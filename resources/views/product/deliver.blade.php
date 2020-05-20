@extends('master.main')

@section('main-content')

  @component('master.notification')
    @slot('title')
      Deliver goods for <span class="font-weight-600">{{$sale->product->name}}</span>
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
            <span>You are about to deliver goods for <span class="font-weight-600">{{$sale->product->name}}</span>. Once delivered, goods cannot be altered</span>
          </div>
          <form class="" action="{{route('deliverpost',['uniqueid'=>$sale->uniqueid])}}" method="post">

          <div class="form-group">
            <label for="bid">Goods:</label>
            <textarea name="goods" rows="8" cols="150" style="resize:none" class="form-control"></textarea>
          </div>

          <div class="form-group">
            <center>
              <button type="submit" name="button" class="btn btn-success">Confirm delivery</button>
              <a href="{{route('products')}}" class="btn btn-danger">Back to products</a>
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
