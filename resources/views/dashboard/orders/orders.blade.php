@extends('adminlte::page')

@section('title', 'Users Orders')

@section('content_header')
@include('includes.parts.msg')
@include('includes.parts.err')

<center>
  <h1 style="font-weight:700;font-size:45px;"> {{ count($orders) }} Orders</h1>
  <h3>This is Lates Users Order .. After Reading Order Delete it !</h3>
</center>




@stop

@section('content')
<div class="content">
  <div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
      @forelse($orders as $order)
        <div class="box box-success">
          <div class="box-header">
            <img src="{{ Request::root() }}/data/users/photos/{{ $order->userphoto }}" class="img-thumbnile" style="border-radius:50%;" width="50" height="50" alt="User Photo">
            <h4 style="display:inline;margin-left:7px;">{{ $order->username }} - <i class="fa fa-clock-o"></i> {{ \Carbon\Carbon::parse($order->orderdatetime)->format('d F Y, h:i A')}}</h4>
          </div>
          <div class="box-body text-center">
            <p>{{ $order->ordercontent }}</p>
          </div>
          <div class="box-footer">
            <div class="btn-group">
              <a href="{{ route('orders.delete',['id' => $order->orderid]) }}" class="btn btn-default btn-sm btn-flat" style="width:200px;"> <i class="fa fa-check"></i> Ok & Delete</a>
              @if($order->userfacebook != '')
                <a href="{{ $order->userfacebook }}" target="_blank" rel="noopener noreferrer" class="btn btn-default btn-sm btn-flat" style="width:200px;"> <i class="fa fa-facebook"></i> Contact with Facebook</a>
              @endif
            </div>
          </div>
        </div>
      @empty
        <center>
          <h2>There are no orders No <i class="fa fa-smile-o"></i> </h2>
        </center>
      @endforelse
      <center>
        {{ $orders->links() }}
      </center>
    </div>
    <div class="col-md-2"></div>
  </div>
</div>
@stop




@section('css')s
<style media="screen">
  /* body{font-family: Segoe UI;} */
  .content-wrapper {background-color: white;}

  .box.box-success {
    border-left: 3px solid #605ca8;
    border-top:0px solid #EEE;
    border-radius: 0px;
    transition: .3s;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
   }
</style>
@stop
