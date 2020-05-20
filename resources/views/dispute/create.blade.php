@extends('master.main')

@section('main-content')

  @component('master.notification')
    @slot('title')
      Create dispute for <span class="font-weight-600">{{$sale->product->name}}</span>
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
              <span>You are about to create dispute for <span class="font-weight-600">{{$sale->product->name}}</span>, because you claim goods are not as described or you believe you got scammed in any other way</span>
          </div>
          <form class="" action="{{route('createdisputepost',['uniqueid'=>$sale->uniqueid])}}" method="post">


          <div class="form-group">
            <label for="bid">Message for admins:</label>
            <textarea name="message" rows="8" cols="150" style="resize:none" class="form-control" ></textarea>
          </div>
          <div class="form-group">
            <center>
              <button type="submit" name="button" class="btn btn-success">Create Dispute</button>
            </center>
          </div>

          <div class="form-group">
            <center>
              <a href="{{route('purchases')}}" class="btn btn-primary">Back to purchases</a>
            </center>
          </div>
          {{csrf_field()}}
          </form>
  @endcomponent

@stop
