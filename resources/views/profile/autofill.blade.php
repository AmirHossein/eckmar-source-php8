@extends('master.main')

@section('main-content')

  @component('master.notification')
    @slot('title')
      Autofill for <span class="font-weight-600">{{$product->name}}</span>
    @endslot

        @if(session()->has('errormessage'))
        <div class="alert alert-danger">
          <strong>Whoops ! </strong><span>{{session()->get('errormessage')}}</span>
        </div>
        @endif
        @if(session()->has('successmessage'))
        <div class="alert alert-success">
          <strong>Whoops ! </strong><span>{{session()->get('successmessage')}}</span>
        </div>
        @endif
          <div class="form-group">
            <span>Each line represents single item that will be sent to user when he purchase product. You can add maximum of 150 items</span>
          </div>
            <form class="" action="{{route('autofillpost',['uniqueid'=>$product->uniqueid])}}" method="post">
          <div class="form-group">
            <textarea name="autofill" rows="15" cols="150" style="resize:none" class="form-control">@if($autofill !== null)@foreach($autofill as $line){{$line."\r"}}@endforeach @endif</textarea>
          </div>



          <div class="form-group">
            <center>
              @if($product->autofill !== null)
              <button type="submit" name="button" class="btn btn-warning">Edit Autofill</button>
              @else
              <button type="submit" name="button" class="btn btn-success">Add Autofill</button>
              @endif
              <a href="{{route('products')}}" class="btn btn-danger">Back to products</a>
            </center>
          </div>

          {{csrf_field()}}
                    </form>
  @endcomponent

@stop
