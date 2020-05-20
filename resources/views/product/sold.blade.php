@extends('master.main')

@section('main-content')

  @component('master.notification')
    @slot('title')
      Product is sold
    @endslot

          <div class="form-group">
            <span>Unfortunately product you are looking for is <strong>sold</strong></span>
          </div>
          <div class="form-group">
            <center>            
              <a href="{{route('profile')}}" class="btn btn-primary">Back to profile</a>
            </center>
          </div>
  @endcomponent

@stop
