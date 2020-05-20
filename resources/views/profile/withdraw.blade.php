@extends('master.main')

@section('main-content')

  @component('master.notification')
    @slot('title')
      Withdraw from balance
    @endslot
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
    <div class="form-group">
      <span>You have total of <span class="font-weight-600">{{Auth::user()->balance*0.00000001}}<span class="glyphicon glyphicon-bitcoin" aria-hidden="true"></span></span> available for withdraw</span>
    </div>
    <form class="" action="{{route('withdrawpost')}}" method="post">
      <div class="form-group">
        <label for="">Withdraw address:</label>
        <input type="text" name="address" value="{{old('address')}}" class="form-control">
      </div>
      <div class="form-group">
        <label for="">How much you want to withdraw:</label>
        <input type="number" name="balance" value="{{old('balance')}}" class="form-control" step="0.001">
      </div>
      <div class="form-group">
        <label for="">PIN:</label>
        <input type="password" name="pin" value="" class="form-control">
      </div>
      <div class="form-group">
        <label for="">Password:</label>
        <input type="password" name="password" value="" class="form-control">
      </div>
      <div class="form-group">
        {!!captcha_img()!!}
      </div>
      <div class="form-group">
        <input type="text" name="captcha" value="" placeholder="Captcha" class="form-control">
      </div>
      <div class="form-group">
        <center>
          <button type="submit" name="button" class="btn btn-success">Withdraw</button>
          <a href="{{route('wallet')}}" class="btn btn-primary">Back to My Wallet</a>
        </center>
      </div>
      {{csrf_field()}}
    </form>
  @endcomponent

@stop
