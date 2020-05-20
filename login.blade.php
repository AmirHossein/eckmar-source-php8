@extends('master.main')

@section('main-content')
<div class="col-md-6 col-md-offset-3">
  <div class="panel panel-default">
    <div class="panel-heading">
      Login
    </div>
    <div class="panel-body">
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
        <div class="col-md-8 col-md-offset-2">
          <form class="" action="{{route('loginpost')}}" method="post">
              <div class="form-group">
                 <label for="username">Username:</label>
                 <input type="text" name="username" id="username" class="form-control" placeholder="Username" value="{{old('username')}}">
              </div>
              <div class="form-group">
                 <label for="password">Password:</label>
                 <input type="password" name="password" id="password" class="form-control" placeholder="Password" value="">
              </div>
              <div class="form-group">
                {!!captcha_img()!!}
                <div class="margin-top-15">

                <input type="text" name="captcha" value="" placeholder="Captcha" class="form-control">

                </div>
              </div>
              <div class="form-group">
                <center>
                  <button type="submit" class="btn btn-success">Login</button>
                  <a href="{{route('register')}}" class="btn btn-primary">Register</a><br><br>
                  <a href="{{route('passwordreset')}}">Forgot your password ?</a>
                </center>
              </div>
              {{csrf_field()}}
          </form>
        </div>
    </div>
  </div>
</div>


@stop
