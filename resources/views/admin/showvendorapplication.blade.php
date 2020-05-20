@extends('admin.master')

@section('content')
<div class="col-xs-8 col-xs-offset-2 m-t-50">
  <div class="form-group">
    Application by {{$va->user->username}} sent {{$va->created_at}}
  </div>
  <div class="form-group">
    <textarea name="name" rows="8" cols="80" class="form-control" readonly="" style="resize:none">{{$va->offer}}</textarea>
  </div>
  <div class="form-group">
    <textarea name="name" rows="8" cols="80" class="form-control" readonly="" style="resize:none">{{$va->void}}</textarea>
  </div>
  <div class="form-group">
    <textarea name="name" rows="8" cols="80" class="form-control" readonly="" style="resize:none">{{$va->other_markets}}</textarea>
  </div>
  <form class="" action="{{route('vapost',['uniqueid'=>$va->uniqueid])}}" method="post">
  <div class="form-group m-t-25">
  @if($va->status == 0)
  <center>
  <button type="submit" name="action" value="approve"class="btn btn-success">Approve</button>
  <button type="submit" name="action" value="decline" class="btn btn-danger m-l-10">Decline</button>
  </center>
  @elseif($va->status == 1)
  <center>
      <span>This application is approved</span>
  </center>
  @elseif($va->status == 2)
  <center>
      <span>This application is declined</span>
  </center>
  @elseif($va->status == 3)
  <center>
      <span>User paid in order to get vendor status</span>
  </center>
  @endif
  <br>
  <a href="{{route('vendorapplications')}}" class="btn btn-primary m-t-25">Back to the list of applications</a>
  </div>
  {{csrf_field()}}
  </form>
</div>
@stop
