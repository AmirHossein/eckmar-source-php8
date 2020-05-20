<nav class="navbar navbar-default">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <a class="navbar-brand" href="{{route('home')}}">{{env('APP_NAME')}}</a>
    </div>

    <ul class="nav navbar-nav navbar-left">
      @if(Auth::check())
       <li><a href="{{route('home')}}">Home<span class="sr-only">(current)</span></a></li>
        @if(Auth::user()->admin == true)
          <li><a href="{{route('admin')}}">AP</a></li>
        @endif
        @if(Auth::user()->sales()->where('state',0)->count() > 0)
          <li><a href="{{route('sales')}}"><strong><span class="glyphicon glyphicon-hourglass" aria-hidden='true'></span>{{Auth::user()->sales()->where('state',0)->count()}} Need delivery</strong></a></li>
        @endif
        @if(Auth::user()->purchases()->where('state',1)->count() > 0)
          <li style="margin-left:-25px;"><a href="{{route('purchases')}}"><strong><span class="glyphicon glyphicon-hourglass" aria-hidden='true'></span>{{Auth::user()->purchases()->where('state',1)->count()}} Need confirmation</strong></a></li>
        @endif
       @endif
    </ul>
        @if(Auth::check())
        <ul class="nav navbar-nav navbar-right">
          @if(Auth::user()->vendor == true)
           <li><a href="{{route('createproduct')}}" class="m-r-10"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Create Product</a></li>
          @endif
            <li><a href="{{route('messages')}}"><span class="glyphicon glyphicon-inbox" aria-hidden="true"></span>@if(Auth::user()->receivedmessages()->where('viewed',false)->count() > 0) {{Auth::user()->receivedmessages()->where('viewed',false)->count()}} @endif</a></li>
            <li><a href="{{route('wallet')}}"><span class="glyphicon glyphicon-bitcoin" aria-hidden="true"></span> {{number_format(Auth::user()->balance*0.00000001, 6, '.', ',')}}</a></li>
            <li><a href="{{route('profile')}}"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Profile</a></li>
           <li><a href="{{route('logout')}}"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Logout</a></li>
          </ul>

        @endif

  </div><!-- /.container-fluid -->
</nav>
