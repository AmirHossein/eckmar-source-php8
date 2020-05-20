@extends('master.main')

@section('main-content')

  @component('master.notification')
    @slot('title')
      Application for vendor status
    @endslot


          <div class="form-group">
            <span>Your vendor application has been sent successfully. Please be patient until admins review your application.</span>
          </div>
          <div class="form-group">
            <center>
              <a href="{{route('profile')}}" class="btn btn-primary">Back to profile</a>
            </center>
          </div>

  @endcomponent

@stop
