@extends('master.main')

@section('main-content')
<div class="col-md-8 col-md-offset-2">


<div class="panel panel-default">
  <div class="panel-heading">
    Create New Product
  </div>
  <div class="panel-body">
    @if(session()->has('errormessage'))
    <div class="alert alert-danger">
      <strong>Whoops ! </strong><span>{{session()->get('errormessage')}}</span>
    </div>
    @endif
    <form class="" action="{{route('createproductpost')}}" method="post" enctype="multipart/form-data">
      {{csrf_field()}}
      <div class="form-group">
        <label for="name">Product name</label>
        <input type="text" name="name" id="name" class="form-control" value="{{old('name')}}" placeholder="Product Name">
      </div>
      <div class="form-group">
        <label for="price">Price in <span class="glyphicon glyphicon-bitcoin" aria-hidden="true"></span> (starting price if auction)</label>
        <input type="number" step="any" name="price" id="price" class="form-control" value="{{old('price')}}" placeholder="Price in Bitcoin">
      </div>
      <div class="form-group">
        <label for="category">Category</label>
        <select multiple class="form-control" id="category" name="category" >
          @foreach($categories as $category)
          <option name="{{$category->name}}">{{$category->name}}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <label for="description">Description</label>
        <textarea name="description" rows="8" cols="80" class="form-control" id="description" style="resize:none">{{old('description')}}</textarea>
      </div>
      <div class="form-group">
        <label for="refund_policy">Refund Policy: </label>
        <textarea name="refund_policy" rows="8" cols="80" class="form-control" id="refund_policy" style="resize:none">{{old('refund_policy')}}</textarea>
      </div>


      <div class="form-group m-t-25">
        <span>Check this box if you want to sell your product on auction</span><br>
        <label class="checkbox-inline">
          <input type="checkbox" id="inlineCheckbox1" value="true" name="auction"> Auction
        </label>
      </div>
      <div class="form-group">
        <label for="">Auction end date: (needed only if auction box is checked, otherwize ingnore)</label>
        <input type="datetime-local" name="end_date" value="" class="form-control">
      </div>
      <div class="form-group">
        <label for="buyout">Auction buyout price: (needed only if auction box is checked, otherwize ingnore)</label>
        <input type="number" step="any" name="buyout" id="buyout" class="form-control" value="{{old('buyout')}}" placeholder="Buyout Price in Bitcoin">
      </div>
      <div class="form-group">
        <div class="form-group">
          <label for="exampleInputFile">Product image:</label>
          <input type="file" id="exampleInputFile" name="image">
          <p class="help-block">Maximum image size is 500kb , only images are allowed</p>
        </div>
      </div>

      <div class="form-group m-b-50 m-t-50">
        <center>
          <button type="submit" name="button" class="btn btn-success">Crete Product</button>
        </center>
      </div>


    </form>
  </div>
</div>

</div>
@stop
