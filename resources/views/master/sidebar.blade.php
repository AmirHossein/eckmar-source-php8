<span class="font-size-20 m-l-10">Categories</span><br>


<div class="list-group">

  @if($categories->count() > 0)
  @foreach($categories as $category)
 <a href="{{route('showcat',['cslug'=>$category->slug])}}" class="list-group-item">{{$category->name}}</a>
  @endforeach
  @endif
</div>
