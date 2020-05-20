@extends('master.main')

@section('main-content')

  @component('master.notification')
    @slot('title')
    Pay for vendor status
    @endslot


          <div class="form-group">
            <span>Congratulations ! You have been granted vendor status </span>
          </div>
          <div class="form-group">
              <center>
                <a href="{{route('profile')}}" class="btn btn-primary">Back to profile</a>
              </center>


          </div>

  @endcomponent

@stop
