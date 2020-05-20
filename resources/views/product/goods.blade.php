@extends('master.main')

@section('main-content')

  @component('master.notification')
    @slot('title')
      Goods for <span class="font-weight-600">{{$sale->product->name}}</span>
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
              <span>These are  goods for <span class="font-weight-600">{{$sale->product->name}}</span>.</span>
          </div>


          <div class="form-group">
            <label for="bid">Goods:</label>
            <textarea name="goods" rows="8" cols="150" style="resize:none" class="form-control" readonly="">{{$sale->goods}}</textarea>
          </div>

            @if(Auth::user()->id == $sale->buyer_id && $sale->state == 1)
            <form class="" action="{{route('confirm',['uniqueid'=>$sale->uniqueid])}}" method="post">
              <div class="form-group">
                <center>
                    <button type="submit" name="button" class="btn btn-success">Confirm delivery</button>
                </center>
                  {{csrf_field()}}
              </div>
            </form>

              <div class="form-group">
                <center>
                  <a href="{{route('createdispute',['uniqueid'=>$sale->uniqueid])}}" class="btn btn-danger">Create Dispute</a>
                </center>

              </div>

            @endif
          <div class="form-group">
            <center>
              @if(Auth::user()->id == $sale->seller_id)
              <a href="{{route('sales')}}" class="btn btn-primary">Back to sales</a>
              @else
              <a href="{{route('purchases')}}" class="btn btn-primary">Back to purchases</a>
              @endif
            </center>
          </div>
          <div class="m-t-5">
            <center>
                <span class="font-size-12">You are protected by <span class="font-weight-600">escrow</span> <span class="glyphicon glyphicon-ok-circle" aria-hidden="true"></span></span>
            </center>
          </div>

  @endcomponent

@stop
