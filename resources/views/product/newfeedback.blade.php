@extends('master.main')

@section('main-content')

  @component('master.notification')
    @slot('title')
      Leave feedback for  <span class="font-weight-600">{{$user->username}}</span>
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
            <span>You are about to leave feedback for <span class="font-weight-600">{{$user->username}}</span>. Once left, feedback cannot be altered later</span>
          </div>
          <form class="" action="{{route('newfeedbackpost',['uniqueid'=>$sale->uniqueid,'u'=>$u])}}" method="post">
            <div class="form-group">
              <div class="radio">
              <label>
                <input type="radio" name="feedback" id="optionsRadios1" value="positive" checked>
                  Positive
              </label>
            </div>
            <div class="radio">
              <label>
                <input type="radio" name="feedback" id="optionsRadios2" value="negative">
                  Negative
              </label>
            </div>

            </div>
          <div class="form-group">
            <label for="bid">Comment: (required)</label>
            <textarea rows="8" cols="150" style="resize:none" class="form-control" name="comment"></textarea>
          </div>
          <div class="form-group">
            <center>
              <span class="text-danger"><strong>You cannot edit this later ! </strong></span>
            </center>
          </div>
          <div class="form-group">
            <center>

              <button type="submit" name="button" class="btn btn-success">Confirm feedback</button>
              <a href="{{route('purchases')}}" class="btn btn-danger">Back to purchases</a>
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
