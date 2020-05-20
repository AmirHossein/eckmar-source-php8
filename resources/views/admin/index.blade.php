@extends('admin.master')

@section('content')
<div class="row" style="margin-top:25px;">

  <form class="" action="{{route('editsettings')}}" method="post">
    {{csrf_field()}}
    <div class="col-md-3">
      <div class="form-group">
        <label> Current price for vendor: (in BTC)</label>
        <input type="number" name="vendor_price" value="{{$settings->vendor_price*0.00000001}}" step="any" class="form-control">
      </div>
    </div>

    <div class="col-md-3">
      <div class="form-group">
        <label>Current profit from fees: (in BTC)</label>
        <input type="number" name="" value="{{$settings->collected_fee*0.00000001}}" step="any" class="form-control" readonly="">
      </div>
    </div>

    <div class="col-md-3">
      <div class="form-group">
        <label>Current fee: (percentage)</label>
        <input type="number" name="fee" value="{{$settings->fee}}" step="any" class="form-control" >
      </div>
    </div>

    <div class="col-md-3">
      <div class="form-group">
        <br>
        <button type="submit" name="button" class="btn btn-warning">Edit Settings</button>
      </div>
    </div>

  </form>

</div>
@stop
