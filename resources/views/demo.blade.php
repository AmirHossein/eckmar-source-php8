@extends('master.main')

@section('main-content')
<div class="panel panel-default">
  <div class="panel-heading">
    Demo
  </div>
  <div class="panel-body">
    <div class="row text-center">
      <h1>Eckmar's Marketplace Script</h1>
    </div>

    <div class="row">
      <div class="col-md-12">
        <p>The script is currently in <span class="label label-default">DEMO</span> mode. Some features are disabled.</p>
      </div>
    </div>


    <div class="row">
      <div class="col-md-12">
        <p>To see full list of features please check one of the threads:</p>
        <ul>
          <li><a href="https://bitcointalk.org/index.php?topic=1879294" target="_blank">Bitcointalk.org Thread</a></li>
          <li><a href="https://hackforums.net/showthread.php?tid=5621843" target="_blank">Hackforums.net Thread</a></li>
        </ul>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <p>My available contact information:</p>
        <ul>
          <li>Skype: <strong>spufa.skrndelj</strong></li>
          <li>Xmpp: <strong>eckmar@xmpp.zone</strong></li>
          <li>Bitcointalk profile: <strong><a href="https://bitcointalk.org/index.php?action=profile;u=42189" target="_blank">Link</a> </strong></li>
          <li>Hackforums profile: <strong><a href="https://hackforums.net/member.php?action=profile&uid=2300285" target="_blank">Link</a> </strong></li>
        </ul>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-primary">
          <div class="panel-heading">
            Demo features
          </div>
          <div class="panel-body">
            @if(Auth::check())
              <div class="row">
                <div class="col-md-12">
                  <a href="{{route('demomoney')}}" class="btn btn-success">Give me money !</a>
                  @if(Auth::user()->admin == false)
                  <a href="{{route('demoadmin')}}" class="btn btn-success">Give me admin status</a>
                  @else
                  <a href="#" class="btn btn-success" disabled>Give me admin status</a>
                  @endif

                  @if(Auth::user()->vendor == false)
                  <a href="{{route('demovendor')}}" class="btn btn-success">Give me vendor status</a>
                  @else
                  <a href="#" class="btn btn-success" disabled>Give me vendor status</a>
                  @endif
                </div>
              </div>

            @else
            <div class="text-center">
              In order to use this features please create new account and log in !
            </div>
            @endif
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

@stop
