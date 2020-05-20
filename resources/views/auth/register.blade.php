@extends('master.main')

@section('main-content')
<div class="col-md-6 col-md-offset-3">
  <div class="panel panel-default">
    <div class="panel-heading">
      Register
    </div>
    <div class="panel-body">
      @if(session()->has('errormessage'))
      <div class="alert alert-danger">
        <strong>Whoops ! </strong><span>{{session()->get('errormessage')}}</span>
      </div>
      @endif
        <div class="col-md-8 col-md-offset-2">
          <form class="" action="{{route('registerpost')}}" method="post">
              <div class="form-group">
                 <label for="username">Username:</label>
                 <input type="text" name="username" id="username" class="form-control" placeholder="Username" value="{{old('username')}}">
              </div>
              <div class="form-group">
                 <label for="password">Password:</label>
                 <input type="password" name="password" id="password" class="form-control" placeholder="Password" value="">
              </div>
              <div class="form-group">
                 <label for="passwordconfirm">Confirm Password:</label>
                 <input type="password" name="passwordconfirm" id="passwordconfirm" class="form-control" placeholder="Confirm Password" value="">
              </div>
              <div class="form-group">
                <label for="pin">PIN:</label>
                <input type="number" name="pin" id="pin" class="form-control" placeholder="6 Digit PIN" value="" >
              </div>
              <div class="form-group">
                <label for="pinconfirm">Confirm PIN:</label>
                <input type="number" name="pinconfirm" id="pinconfirm" class="form-control" placeholder="Confirm PIN" >
              </div>
              <div class="form-group">
                {!!captcha_img()!!}
                <div class="margin-top-15">

                <input type="text" name="captcha" value="" placeholder="Captcha" class="form-control">

                </div>
              </div>
              <div class="form-group">
                <center>
                  <button type="submit" class="btn btn-success">Register</button><br><br>
                  <a href="{{route('login')}}">Back to login</a>
                </center>
              </div>
              {{csrf_field()}}
          </form>
        </div>
    </div>
  </div>
</div>


@stop
