@extends('master.main')

@section('main-content')
<div class="col-md-6 col-md-offset-3">
  <div class="panel panel-default">
    <div class="panel-heading">
      Apply for vendor status
    </div>
    <div class="panel-body">
      @if(session()->has('errormessage'))
      <div class="alert alert-danger">
        <strong>Whoops ! </strong><span>{{session()->get('errormessage')}}</span>
      </div>
      @endif
          <div class="form-group m-t-10 m-b-10">
              <span>Before you can apply for vendor status you must have your public PGP key set </span>
          </div>

          <form class="" action="{{route('vendorapplypost')}}" method="post">
              <div class="form-group">
                 <label for="offer">What will you offer to the marketplace ? </label>
                 <textarea name="offer" rows="8" cols="80" class="form-control" style="resize:none">{{old('offer')}}</textarea>
              </div>
              <div class="form-group">
                <label for="void">Why do you deserve to void payment ? </label>
                <textarea name="void" rows="8" cols="80" class="form-control" style="resize:none">{{old('void')}}</textarea>
              </div>
              <div class="form-group">
                <label for="other_markets">Experience on other markets/forums ? </label>
                <textarea name="other_markets" rows="8" cols="80" class="form-control" style="resize:none">{{old('other_markets')}}</textarea>
              </div>
              <div class="form-group">
                <center>
                  <button type="submit" class="btn btn-success">Apply for vendor status</button>
                </center>
              </div>
              {{csrf_field()}}
          </form>

    </div>
  </div>
</div>


@stop
