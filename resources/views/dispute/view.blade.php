@extends('master.main')

@section('main-content')

  @component('master.notification')
    @slot('size')
    col-md-8 col-md-offset-2
    @endslot
    @slot('title')
      Dispute for <span class="font-weight-600">{{$purchase->product->name}}</span>
    @endslot

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
          <div class="form-group">
              <span>This is dispute for  <span class="font-weight-600">{{$purchase->product->name}}</span></span>
          </div>

        @foreach($replies as $reply)
        <div class="form-group">
          <label for="">From: {{$reply->user->username}} @if($reply->adminreply == true)<span class="label label-success">Admin</span> @elseif($reply->user->id == $purchase->buyer->id) <span class="label label-primary">Buyer</span> @elseif($reply->user->id == $purchase->seller->id)<span class="label label-primary">Seller</span>  @else <span class="label label-default">Undefined Role</span>@endif</label>
          <textarea name="name" rows="8" cols="80" style="resize:none" readonly="" class="form-control">{{$reply->message}}</textarea>
        </div>
        @endforeach

        @if($dispute->resolved == false)
        <form class="" action="{{route('addreply',['uniqueid'=>$dispute->uniqueid])}}" method="post">
          {{csrf_field()}}
            @if($dispute->replies()->where('user_id',Auth::user()->id)->count() >= 3 && Auth::user()->admin == false && $dispute->replies()->where('adminreply',true)->count() == 0)
            <div class="form-group">
              <center>
                You cannot reply more than 3 times on this dispute until admin adds his reply
              </center>
            </div>
            @else
            <div class="form-group">
              <label for="message">Add new reply</label>
              <textarea name="message" rows="8" cols="80" class="form-control" id="message"></textarea>
            </div>
            <div class="form-group">
              <center>
                @if((Auth::user()->admin == true && Auth::user()->id == $dispute->buyer->id) || (Auth::user()->admin == true && Auth::user()->id == $dispute->seller->id) || Auth::user()->admin == true)
                  <button type="submit" name="adminbtn" value="adminbtn" class="btn btn-warning">Add Reply as Admin</button>
                @endif
                @if(Auth::user()->id == $dispute->buyer->id || Auth::user()->id == $dispute->seller->id)
                <button type="submit" name="button" class="btn btn-primary">Add Reply</button>
                @endif
              </center>
            </div>
            @endif
          <div class="form-group">
            <center>
              @if(Auth::user()->id == $dispute->buyer->id)
              <a href="{{route('purchases')}}" class="btn btn-default">Back to the list of purchases</a>
              @elseif(Auth::user()->id == $dispute->seller->id)
              <a href="{{route('sales')}}" class="btn btn-default">Back to the list of sales</a>
              @else
              <a href="{{route('disputes')}}" class="btn btn-default">Back to admin panel</a>

              @endif
            </center>
          </div>
        </form>
        @if(Auth::user()->admin == true)
        <form class="" action="{{route('resolve',['uniqueid'=>$dispute->uniqueid])}}" method="post">
          <div class="form-group">
            <center>
              <button type="submit" name="resolve" value="buyer" class="btn btn-primary">Decide in favor of buyer</button>
              <button type="submit" name="resolve" value="seller" class="btn btn-primary">Decide in favor of seller</button>
            </center>
          </div>
          {{csrf_field()}}
        </form>

        @endif

        @else
        <div class="form-group">
          <center>
            <a href="{{route('disputes')}}" class="btn btn-primary">Back to admin panel</a>
          </center>
        </div>
        @endif
  @endcomponent

@stop
