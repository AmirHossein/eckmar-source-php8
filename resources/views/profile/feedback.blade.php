@extends('profile.master')

@section('content')
<div class="margin-top-25 margin-bottom-25">
<center>
  <span>Current feedback score: {{Auth::user()->feedbackScore()}}</span><br>
  <span>Trust rating: {{Auth::user()->trustRating()}}</span>
<div class="row">
  <div class="col-md-4 col-md-offset-4">
    <div class="progress">
    <div class="progress-bar @if(Auth::user()->feedbackScore() < 25 || Auth::user()->trustRating() == 'Unproven') progress-bar-danger @elseif(Auth::user()->feedbackScore() < 50) progress-bar-warning @elseif(Auth::user()->feedbackScore() < 70) progress-bar-info @else progress-bar-success @endif" role="progressbar"  aria-valuemin="0" aria-valuemax="100" style="width: {{Auth::user()->feedbackScore()}}%;">
      <span  @if(Auth::user()->feedbackScore() < 25) style="color:#000" @endif>{{Auth::user()->trustRating()}}</span>
    </div>
  </div>
  </div>
</div>

</center>
</div>
<table class="table table-hover">
    <thead>
      <td>From</td>
      <th>Type</th>
      <th>My Role</th>
      <th>Comment</th>
      <th>Creation Time</th>

    </thead>
    <tbody>
      @foreach($feedback as $fd)
        <tr>
          <td>@if($fd->for == $fd->buyer->id) {{$fd->seller->username}} @else {{$fd->buyer->username}} @endif</td>
          <td>@if($fd->positive == true) <span class="label label-success">Positive</span>@else <span class="label label-danger"> Negative</span> @endif</td>
          <td>@if($fd->seller->id == Auth::user()->id) Seller @else Buyer @endif</td>
          <td>{{str_limit($fd->comment, $limit = 40, $end = '...') }}</td>
          <td>{{$fd->created_at}}</td>
        </tr>
      @endforeach
    </tbody>
</table>
<div class="m-t-25">
<center>
{{$feedback->links()}}
</center>
</div>
@stop
