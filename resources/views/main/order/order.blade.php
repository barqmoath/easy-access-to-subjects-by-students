@extends('layouts.app')
@section('title','Order From EASS')


@section('content')
<div class="container">
  @include('includes.parts.err')
</div>

@if(!session('msg'))
  <div class="container text-center">
    <h1 style="font-size:8rem;margin:10px;font-weight:100;" >What do you need?</h1>
    <h3 style="font-weight:100;">Identify what you are missing in your studies and ask the EASS team <i class="fa fa-heart-o"></i> </h3>
  </div>
  <div class="container" style="min-height:79.5vh;margin-top:30px;">
    <div class="row">
      <div class="col-md-6">
        <div class="user-space text-center">
          <img class="" style="border-radius:50%;" width="100" height="100" src="{{ Request::root() }}/data/users/photos/{{ Auth::user()->photo }}" alt="User Photo">
        </div>
        <form style="margin-top:30px;" action="{{ route('order.send') }}" method="post">
          {{ csrf_field() }}
          <div class="md-form">
            <textarea type="text" name="order_content" class="md-textarea form-control" rows="3" required autocomplete="off"></textarea>
            <label for="form10">Write Your Order</label>
          </div>
          <button type="submit" name="submit" class="btn btn-primary btn-block"> <i class="fa fa-paper-plane-o" style="font-size:1.4rem;"></i> Send Order</button>
        </form>
      </div>
      <div class="col-md-6 text-center">
        <!-- Order Image -->
        <img style="margin-top:40px;" src="{{ Request::root() }}/vendor/main/img/order-01.png" alt="Order">
      </div>
    </div>
    <center>
      <h6 class="text-center" style="color:#607D8B;margin:50px;font-size:1.4rem;">Order is a tool that enables you to communicate with the site administrators and offer you the desire to submit content that helps you to provide the best performance in your school life. <i class="fa fa-smile-o"></i> </h6>
    </center>
  </div>
@else
<div class="container text-center" style="min-height:67.9vh;margin-top:30px;">
  <h1 style="font-size:8rem;margin:10px;margin-top:50px;font-weight:100;" >Order is Sent !</h1>
  <h3 style="font-weight:100;">If you think you forget about somethink Please Send More <i class="fa fa-heart-o"></i> </h3>
  <a href="{{ route('order') }}" class="btn btn-primary btn-block"><i class="fa fa-hand-grab-o" style="font-size:1.4rem;"></i> Send More</a>
</div>
@endif

@stop

@section('css')
<style media="screen">
.btn-primary {
  background-color: #FF5722!important;
  color: #fff!important;
  text-transform: initial;
  font-size: 1.4rem;
}

.btn-primary:hover{
  background-color: #4e2113!important;
}

</style>
@stop
