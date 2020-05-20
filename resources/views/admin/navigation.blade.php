<ul class="nav nav-tabs">
  <li role="presentation" @if(Route::currentRouteName() == 'admin') class="active" @endif><a href="{{route('admin')}}">Home</a></li>
  <li role="presentation" @if(Route::currentRouteName() == 'categories') class="active" @endif><a href="{{route('categories')}}">Categories</a></li>
  <li role="presentation" @if(Route::currentRouteName() == 'vendorapplications') class="active" @endif><a href="{{route('vendorapplications')}}">Vendor Applications</a></li>
  <li role="presentation" @if(Route::currentRouteName() == 'disputes') class="active" @endif><a href="{{route('disputes')}}">Disputes</a></li>
  <li role="presentation" @if(Route::currentRouteName() == 'news') class="active" @endif><a href="{{route('news')}}">News</a></li>
</ul>
