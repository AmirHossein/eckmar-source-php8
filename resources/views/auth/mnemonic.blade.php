@extends('master.main')

@section('main-content')
<div class="col-md-6 col-md-offset-3">
  <div class="panel panel-default">
    <div class="panel-heading">
      Registration complete
    </div>
    <div class="panel-body">
     Your registration is successful. This is your 16 key mnemonic. Keep it somewhere safe, if you lose it you won't be able to recover your account
         <div class="well margin-top-25">{{$mnemonic}}</div>
     <center>
     <a href="{{route('verify')}}" class="btn btn-primary">Continue to verify</a>
      </center>

  </div>
</div>


@stop
