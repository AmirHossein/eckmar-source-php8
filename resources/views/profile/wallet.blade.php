@extends('profile.master')

@section('content')
<div class="row">
  <div class="col-md-6 col-md-offset-3">
    @if(session()->has('errormessage'))
    <div class="alert alert-danger">
      <strong>Whoops ! </strong><span>{{session()->get('errormessage')}}</span>
    </div>
    @endif
    @if(session()->has('successmessage'))
    <div class="alert alert-success">
      <strong>Yay! </strong><span>{{session()->get('successmessage')}}</span>
    </div>
    @endif
  </div>
</div>
<div class="row">


<div class="m-t-25">
<center>
  Your current balance is <span class="font-weight-600">{{number_format(Auth::user()->balance*0.00000001, 6, '.', ',')}} <span class="glyphicon glyphicon-bitcoin" aria-hidden="true"></span></span>
</center>
</div>
<div class="m-t-25">
<center>
  <a href="{{route('generateaddress')}}" class="btn btn-primary">Generate New Deposit Address</a>
  <a href="{{route('checkbalance')}}" class="btn btn-success">Check Balance</a>
</center>
</div>
<div class="m-t-25">
<center>
  <a href="{{route('withdraw')}}" class="btn btn-success">Withdraw</a>  
</center>
</div>
</div>
@stop
