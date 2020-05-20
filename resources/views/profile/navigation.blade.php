<ul class="nav nav-tabs">
  <li role="presentation" @if(Route::currentRouteName() == 'profile') class="active" @endif><a href="{{route('profile')}}">General Info</a></li>
  <li role="presentation" @if(Route::currentRouteName() == 'products') class="active" @endif><a href="{{route('products')}}">My Products</a></li>
  <li role="presentation" @if(Route::currentRouteName() == 'sales') class="active" @endif><a href="{{route('sales')}}">My Sales</a></li>
  <li role="presentation" @if(Route::currentRouteName() == 'purchases') class="active" @endif><a href="{{route('purchases')}}">My Purchases</a></li>
  <li role="presentation" @if(Route::currentRouteName() == 'feedback') class="active" @endif><a href="{{route('feedback')}}">My Feedback</a></li>
    <li role="presentation" @if(Route::currentRouteName() == 'wallet') class="active" @endif><a href="{{route('wallet')}}">My Wallet</a></li>
</ul>
