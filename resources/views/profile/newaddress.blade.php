@extends('master.main')

@section('main-content')

  @component('master.notification')
    @slot('title')
      New Deposit address
    @endslot

    <div class="form-group">
      <span>Use this address only for one payment in order to achieve best security.</span>
    </div>
    <div class="form-group">
      <input type="text" name="" value="{{$address}}" readonly="" class="form-control">
    </div>
    <div class="form-group">
      <center>
        <a href="{{route('wallet')}}" class="btn btn-primary">Back to My Wallet</a>
      </center>
    </div>
  @endcomponent

@stop
