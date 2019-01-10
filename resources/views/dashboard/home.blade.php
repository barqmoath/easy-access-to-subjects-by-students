@extends('adminlte::page')

@section('title', 'EASS Dashboard')

@section('content_header')
<center>
  <h1 style="font-weight:700;font-size:45px;">Welcome Again</h1>
</center>
@stop

@section('content')
<div class="content">

  <div class="row">


    <div class="col-md-4">
      <div class="box box-widget widget-user">
        <div class="widget-user-header" style="background-color:#605CA8; color:white;">
          <h3 class="widget-user-username">{{ Auth::user()->name }}</h3>
          <h5 class="widget-user-desc" style="margin-top:5px;">{{ Auth::user()->email }}</h5>
        </div>
        <div class="widget-user-image" style="top:70px;">
          <img class="img-circle" src="{{ Request::root() }}/data/users/photos/{{ Auth::user()->photo }}" alt="User Avatar">
        </div>
        <div class="box-footer">
          <div class="row">
            <div class="col-sm-5">
              <div class="description-block">
                <h5 class="description-header">{{ $data['items_user_counter'] }}</h5>
                <span class="description-text">ITEMS</span>
              </div>
            </div>
            <div class="col-sm-7">
              <div class="description-block">
                <a class="btn btn-default btn-flat btn-block" target="_blank" href="{{ route('profile.my_profile') }}"><i class="fa fa-edit"></i> My Profile</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-8" style="padding: 20px;">
      <center>
        <div style="display:block;margin-bottom: 20px;">
          <h3>Your Role is : <span class="label label-danger">{{ Auth::user()->role }}</span> </h3>
        </div>
         <a href="{{ route('home') }}" class="btn btn-default btn-sm btn-flat" style="width:100%;"><i class="fa fa-home"></i>  Go To Home</a>

         @if($data['orders_count'] > 0)
          <h1 style="color:#27ae60;">New Orders</h1>
         @endif
      </center>
    </div>






  </div>

  <hr>



  <div class="row">

    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box" style="background-color:#8e44ad; color: white;">
        <span class="info-box-icon"><i class="fa fa-user-o"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">USERS</span>
          <span class="info-box-number">{{ $data['users_counter'] }}</span>
          <div class="progress">
            <div class="progress-bar" style="width: {{ $data['users_counter'] }}%"></div>
          </div>
          <span class="progress-description">Users Count</span>
        </div>
      </div>
    </div>

    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box" style="background-color:#27ae60; color: white;">
        <span class="info-box-icon"><i class="fa fa-folder-o"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">ITEMS</span>
          <span class="info-box-number">{{ $data['items_counter'] }}</span>
          <div class="progress">
            <div class="progress-bar" style="width: {{ $data['items_counter'] }}%"></div>
          </div>
          <span class="progress-description">Items Count</span>
        </div>
      </div>
    </div>

    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box" style="background-color:#d35400; color: white;">
        <span class="info-box-icon"><i class="fa fa-table"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">SUBJECTS</span>
          <span class="info-box-number">{{ $data['subjects_counter'] }}</span>
          <div class="progress">
            <div class="progress-bar" style="width: {{ $data['subjects_counter'] }}%"></div>
          </div>
          <span class="progress-description">Subjects Count</span>
        </div>
      </div>
    </div>

    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box" style="background-color:#B53471; color: white;">
        <span class="info-box-icon"><i class="fa fa-comments-o"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">COMMENTS</span>
          <span class="info-box-number">{{ $data['comments_counter'] }}</span>
          <div class="progress">
            <div class="progress-bar" style="width: {{ $data['comments_counter'] }}%"></div>
          </div>
          <span class="progress-description">Comments Count</span>
        </div>
      </div>
    </div>

  </div>


<hr>

@if($data['orders_count'] > 0)
  <center>
    <h1 style="margin:20px;font-size:7rem!important;">{{ $data['orders_count'] }} Orders</h1>
    <a href="{{ route('orders.index') }}" style="width:50%;" class="btn btn-default bg-purple btn-lg">Open Orders</a>
  </center>
@endif

</div>
@stop










@section('css')
  <style media="screen">
       /* body{font-family: Segoe UI;} */
      .content-wrapper {background-color: white;}
  </style>
@stop
