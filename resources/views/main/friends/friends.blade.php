@extends('layouts.app')
@section('title','Friends')

@section('content')
<div class="container">
  @include('includes.parts.msg')
  @include('includes.parts.err')
</div>


<!-- User Profile -->
<div class="container">
    <div class="profile">
        <div class="row">
            <div class="col-md-6 text-center">
                <img class="" src="{{ Request::root() }}/data/users/photos/{{ $my_info->userphoto }}" width="200" height="200" style="margin:20px auto;border-radius:50%;border-color:#FAFAFAFA;" alt="User Photo">
            </div>
            <div class="col-md-6 text-center">
                <div class="my-info" style="margin-top:30px;">
                    <h1 style="font-weight:700!important;">{{ $my_info->username }}</h1>
                    <h3 style="color:#607d8b;"> {{ $my_info->departmentname }} <i class="fa fa-arrow-right"></i> {{ $my_info->stagename }} </h3>
                    <h4 style="color:#607d8b;"><i class="fa fa-star-o"></i> {{ $my_info->userrole }} </h4>
                    <h4 style="color:#607d8b;"><i class="fa fa-clock-o"></i> Join at {{ \Carbon\Carbon::parse($my_info->joinat)->format('d F Y')}}</h4>
                    @if(!empty($my_info->userfacebook))
                        <a href="{{ $my_info->userfacebook }}" target="_blank" class="btn btn-primary" style="margin-top:7px;"><i class="fa fa-facebook"></i> Facebook</a>
                    @endif
                        <a href="{{ route('profile.my_profile') }}" target="_blank" class="btn btn-primary" style="margin-top:7px;"><i class="fa fa-edit"></i> Edit Profile</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container" style="min-height:50vh;">
    <div class="profile">
        <h1 style="margin:20px;"> {{ count($friends) }} Friend</h1>
        <div class="row">
            @forelse($friends as $friend)
            <div class="col-md-4">
                <div class="user-card text-center">
                    <img class="" src="{{ Request::root() }}/data/users/photos/{{ $friend->userphoto }}" width="120" height="120" style="margin:10px auto;border-radius:50%;border-color:#FAFAFAFA;" alt="User Photo">
                    @if($friend->userrole === 'Owner')
                        <h4>{{ $friend->username }} <i class="fa fa-star" style="color:red"></i></h4>
                    @elseif($friend->userrole === 'Administrator')
                         <h4>{{ $friend->username }} <i class="fa fa-star" style="color:yellow"></i></h4>
                    @elseif($friend->userrole === 'Uploader')
                        <h4>{{ $friend->username }} <i class="fa fa-star" style="color:green"></i></h4>
                    @else
                        <h4>{{ $friend->username }}</h4>
                    @endif

                    <h6>{{ $friend->departmentname }} <i class="fa fa-arrow-right"></i> {{ $friend->stagename }}</h6>
                    @if(!empty($friend->userfacebook))
                    <a href="{{ $friend->userfacebook }}" target="_blank" class="btn btn-primary btn-sm btn-block"> <i class="fa fa-facebook"></i> Facebook</a>
                    @endif

                </div>
            </div>
            @empty
            <!-- <center>
                <h2>" >No Friends<i class="fa fa-meh-o"></i></h2>
            </center> -->
            @endforelse
        </div>
    </div>
</div>




@stop

@section('css')
<style media="screen">

.profile {
    margin: 10px;
    padding: 10px;
    border: 1px solid #eee;
    border-radius: 0.5rem;
    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.1), 0 6px 40px 0 rgba(0, 0, 0, 0.1);
    transition: all .4s;
}

.user-card {
    margin:15px;
}
.btn-primary {
  width: 200px;
  background-color:#3f51b5!important;
  font-size:1rem!important;
  text-transform: initial;
}
.btn-primary:hover{
  background-color: #234988 !important;
}

</style>
@stop
