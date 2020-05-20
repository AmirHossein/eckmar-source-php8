@extends('master.main')


@section('main-content')
<ol class="breadcrumb">
  <li><a href="{{route('home')}}">Home</a></li>
  <li class="active">{{$user->username}}</li>
</ol>
<div class="col-md-8 col-md-offset-2">
  <div class="panel panel-default">
  <div class="panel-heading">
    <div class="row">
      <div class="pull-left margin-left-25">
        <span class="font-size-24">{{$user->username}}</span><br>
        @if($user->vendor == true)
        <span class="label label-success">Vendor</span>
        @endif
        <span>Last seen: {{date_format(date_create($user->last_seen),"M d, Y")}}</span>
      </div>

      <div class="pull-right margin-right-25">
        <a href="{{route('viewstore',['uniqueid'=>$user->uniqueid])}}" class="btn btn-success">{{$user->username}}'s store</a>
        <a href="{{route('sendmessage',['username'=>$user->username])}}" class="btn btn-primary">Send Message</a>

      </div>

    </div>
  </div>

  <div class="panel-body">
    <div class="pull-left margin-left-25">
      <div class="row">
        <span class="font-weight-600">{{$user->username}}'s Feedback</span><br>
      </div>
      <div class="row m-t-15">
        <div class="col-md-4">
          <center>
          <span class="font-weight-600">{{$user->feedback()->where('positive',true)->count()}}</span>
          <span>Positive</span>
          </center>
        </div>

        <div class="col-md-4">
          <center>
          <span class="font-weight-600">{{$user->feedback()->where('positive',false)->count()}}</span>
          <span>Negative</span>
          </center>
        </div>

      </div>
    </div>


    <div class="pull-right margin-right-25">
      <div class="row">
        <span class="font-weight-600">Latest Feedback</span><br>
      </div>
      <div class="row m-t-15">
        @if($user->feedback()->orderBy('created_at','desc')->first() !== null)
        <i><span> "{{str_limit($user->feedback()->orderBy('created_at','desc')->first()->comment, $limit = 40, $end = '...') }}"</span></i><br>
       <em><span class="font-size-10">From: {{$user->feedback()->orderBy('created_at','desc')->first()->buyer->username}}</span></em>
       @endif
      </div>
    </div>


  </div>

  </div>

  <div class="row">
    <ul class="nav nav-tabs">
    <li role="presentation" @if($item == 'profile')class="active" @endif><a href="{{route('viewprofile',['uniqueid'=>$user->uniqueid,'item'=>'profile'])}}">Profile</a></li>
    <li role="presentation" @if($item == 'pgp')class="active" @endif><a href="{{route('viewprofile',['uniqueid'=>$user->uniqueid,'item'=>'pgp'])}}">PGP Key</a></li>
    <li role="presentation" @if($item == 'feedback')class="active" @endif><a href="{{route('viewprofile',['uniqueid'=>$user->uniqueid,'item'=>'feedback'])}}">Feedback</a></li>
    </ul>
  </div>

  <div class="row margin-top-25">
    @if($item == 'profile')
    <span>{{$user->profile}}</span>
    @elseif($item == 'pgp')
    @if($user->pgp !== null)
        <textarea name="name" rows="8" cols="80" class="form-control" readonly="" style="resize:none">{{$user->pgp}}</textarea>
    @else
    <span>{{$user->username}} did not set his PGP key</span>
    @endif

    @elseif($item == 'feedback')
    <div class="margin-top-25 margin-bottom-15">
    <center>
      <span>Current feedback score: {{$user->feedbackScore()}}</span><br>
      <span>Trust rating: {{$user->trustRating()}}</span>
    <div class="row">
      <div class="col-md-4 col-md-offset-4">
        <div class="progress">
        <div class="progress-bar @if($user->feedbackScore() < 25 || $user->trustRating() == 'Unproven') progress-bar-danger @elseif($user->feedbackScore() < 50) progress-bar-warning @elseif($user->feedbackScore() < 70) progress-bar-info @else progress-bar-success @endif" role="progressbar"  aria-valuemin="0" aria-valuemax="100" style="width: {{$user->feedbackScore()}}%;">
          <span  @if($user->feedbackScore() < 25) style="color:#000" @endif>{{$user->trustRating()}}</span>
        </div>
      </div>
      </div>
    </div>
    <span>Feedback from buyers:</span><br>
    <table class="table table-hover">
      <thead>
        <th>From</th>
        <th>Type</th>
        <th>Comment</th>
        <th>Time</th>
      </thead>

      <tbody>
    @foreach($user->feedback as $fd)
      @if($fd->for == $fd->seller_id && $fd->active == true)
      <tr>
        <td>{{$fd->buyer->username}}</td>
        <td>@if($fd->positive == true) <span class="label label-success">Positive</span>@else <span class="label label-danger"> Negative</span> @endif</td>
        <td>{{str_limit($fd->comment, $limit = 40, $end = '...') }}</td>
        <td>{{$fd->created_at}}</td>
      </tr>
      @endif
    @endforeach
      </tbody>
    </table>
    </center>
    </div>
    @endif
  </div>

</div>
@stop
