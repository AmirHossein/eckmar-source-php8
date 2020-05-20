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
        <div class="col-md-8 col-md-offset-2">
          <form class="" action="{{route('passwordresetpost')}}" method="post">
            <div class="form-group">
              In order to reset password you need 16 key mnemonic that was shown to you after  registration
            </div>
              <div class="form-group">
                 <label for="username">Username:</label>
                 <input type="text" name="username" id="username" class="form-control" placeholder="Username" value="{{old('username')}}">
              </div>
              <div class="form-group">
                 <label for="password">Mnemonic:</label>
                 <textarea name="mnemonic" rows="8" cols="80" class="form-control" style="resize: none"></textarea>
              </div>
              <div class="form-group">
                 <label for="password">New Password:</label>
                 <input type="password" name="password" id="password" class="form-control" placeholder="New Password" >
              </div>
              <div class="form-group">
                {!!captcha_img()!!}
                <div class="margin-top-15">

                <input type="text" name="captcha" value="" placeholder="Captcha" class="form-control">

                </div>
              </div>
              <div class="form-group">
                <center>
                  <button type="submit" class="btn btn-success">Reset Password</button><br><br>
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
