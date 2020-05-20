@extends('master.main')

@section('main-content')

  @component('master.notification')
    @slot('title')
      Dispute resolved
    @endslot
    <div class="form-group">
      Dispute you are looking for is resolved
    </div>
    <div class="form-group">
      <center>
        <a href="{{route('profile')}}" class="btn btn-default">Okay</a>
      </center>
    </div>

  @endcomponent

@stop
