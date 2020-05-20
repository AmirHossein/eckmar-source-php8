@extends('master.main')

@section('main-content')

  @component('master.notification')
    @slot('title')
    Pay for vendor status
    @endslot
          @if(session()->has('errormessage'))
          <div class="alert alert-danger">
            <strong>Whoops ! </strong><span>{{session()->get('errormessage')}}</span>
          </div>
          @endif

          <div class="form-group">
            <span>Current price for vendor status is {{$settings->vendor_price*0.00000001}}<span class="glyphicon glyphicon-bitcoin" aria-hidden="true"></span></span>
          </div>
          <div class="form-group">
            <form class="" action="{{route('vendorpaypost')}}" method="post">
              <center>
                <button type="submit" name="button" class="btn btn-success">Pay now</button>
                <a href="{{route('profile')}}" class="btn btn-primary">Back to profile</a>
              </center>
              {{csrf_field()}}
            </form>

          </div>

  @endcomponent

@stop
