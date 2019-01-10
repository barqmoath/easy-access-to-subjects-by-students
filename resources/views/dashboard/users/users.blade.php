@extends('adminlte::page')

@section('title', 'EASS Users')

@section('content_header')
@include('includes.parts.msg')
@include('includes.parts.err')

<center>
  <h1 style="font-weight:700;font-size:45px;">Users</h1>
</center>

<div class="row">
  <div class="col-md-8">

    <div class="btn-group" style="margin-top:20px; width:100%; margin-left:10px;display:block;">
      <button type="button" class="btn btn-default bg-purple dropdown-toggle" data-toggle="dropdown">
        Actions
        <span class="caret"></span>
        <span class="sr-only">Toggle Dropdown</span>
      </button>
      <ul class="dropdown-menu" role="menu" style="top:32px; border-radius:0px;">
        <li><a onclick="return confirm('Are you sure you want to active all users ?')" href="{{ route('users.active_all') }}"><i class="fa fa-check"></i> Activate all blocked users</a></li>
        <li><a onclick="return confirm('Are you sure you want to block all users ?')" href="{{ route('users.block_all') }}"><i class="fa fa-ban"></i> Block all active users</a></li>
      </ul>
    </div>

    <div class="btn-group" style="margin-top:20px; width:100%; margin-left:10px;display:block;">
      <button type="button" class="btn btn-default bg-purple dropdown-toggle" data-toggle="dropdown">
        Show Options
        <span class="caret"></span>
        <span class="sr-only">Toggle Dropdown</span>
      </button>
      <ul class="dropdown-menu" role="menu" style="border-radius:0px;top:32px;left:78px;">
        <li><a href="{{ route('users.index',['showState' => 'all-users' ]) }}">Show all users</a></li>
        <li><a href="{{ route('users.index',['showState' => 'active-users' ]) }}">Show active users only</a></li>
        <li><a href="{{ route('users.index',['showState' => 'blocked-users' ]) }}">Show blocked users only</a></li>
      </ul>
    </div>
    @if(Auth::user()->role === 'Owner')
      <a href="{{ route('managers') }}" class="btn btn-default bg-purple"> <i class="fa fa-user-secret"></i> Managers</a>
    @endif
      <a href="{{ route('users.index',['showState' => 'all-users' ]) }}" class="btn btn-default bg-purple" style="margin-left:-4px;"> <i class="fa fa-refresh"></i> Refresh</a>


 </div>

  <div class="col-md-4">
   <form class="search-form" action="{{ route('users.index',['showState' => 'search']) }}" method="get">
      <div class="input-group margin" style="margin-top: 18px;">
      	@php 
      		$txt = isset($_GET['txt']) ? $_GET['txt'] : '';
      	@endphp
        <input type="text" class="form-control" value="{{ $txt }}" name="txt" placeholder="Search by name or email .." required  autofocus autocomplete="off">
        <span class="input-group-btn">
          <button type="button" name="button" class="btn btn-defualt btn-flat bg-purple"><i class="fa fa-search"></i></button>
        </span>
      </div>
    </form>
  </div>
</div>

@stop

@section('content')
<div class="content">
  <div class="box box-danger" style="border-radius:0px; border-top-color:#605CA8;">
    <div class="box-body">
      @if(count($users_data) > 0)
        <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <th>Username</th>
                <th>Email</th>
                <th class="text-center">Role</th>
                <th class="text-center">State</th>
                <th class="text-center">Join Date</th>
                <th class="text-center">Action</th>
              </thead>
              <tbody>
                @foreach($users_data as $user)
                  <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td class="text-center">{{ $user->role }}</td>
                    <td>
                      @if($user->state === 1)
                        <span style="width:100%; background-color:#27ae60; border-radius:2px; color:white; display:block;text-align:center;padding:3px;">Active</span>
                      @else
                        <span style="width:100%; background-color:#c0392b; border-radius:2px; color:white; display:block;text-align:center;padding:3px;">Blocked</span>
                      @endif
                    </td>
                    <td class="text-center">{{ Carbon\Carbon::parse($user->created_at)->format('d-m-Y') }}</td>
                    <td class="text-center">
                      <div class="btn-group">

                        <!-- Delete User Button -->
                        <a href="{{ route('users.delete',['uid' => $user->id]) }}" onclick="return confirm('Are you sure you want to delete this user? .. This measure is a final measure can not be reversed after and can not be recovered any data')" class="btn btn-default btn-sm" style="width:55px;">Delete</a>
                        @if($user->state === 1)
                        <!-- Block User Button -->
                        <a href="{{ route('users.block',['uid' => $user->id]) }}" onclick="return confirm('Are you sure you want to Block this user?')" class="btn btn-default btn-sm" style="width:55px;">Block</a>
                        @endif
                        @if($user->state === 0)
                        <!-- Active User Button -->
                        <a href="{{ route('users.active',['uid' => $user->id]) }}" onclick="return confirm('Are you sure you want to Active this user?')" class="btn btn-default btn-sm" style="width:55px;">Active</a>
                        @endif

                        @if(Auth::user()->role === 'Owner')
                          <button type="button" class="btn btn-default btn-flat btn-sm dropdown-toggle" data-toggle="dropdown">
                            Change Role
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                          </button>
                          <ul class="dropdown-menu" role="menu" style="border-radius:0px;">
                            @if($user->state === 1)
                              @if($user->role != 'Owner')
                               <li><a onclick="return confirm('Are you sure?')" href="{{ route('users.make_owner',['id' => $user->id , 'S' => 'default']) }}">Make as Owner</a></li>
                              @endif
                              @if($user->role != 'Administrator')
                               <li><a onclick="return confirm('Are you sure?')" href="{{ route('users.make_administrator',['id' => $user->id , 'S' => 'default']) }}">Make as Administrator</a></li>
                              @endif
                              @if($user->role != 'Uploader')
                               <li><a onclick="return confirm('Are you sure?')" href="{{ route('users.make_uploader',['id' => $user->id , 'S' => 'default']) }}">Make as Uploader</a></li>
                              @endif
                              @if($user->role != 'User')
                               <li><a onclick="return confirm('Are you sure?')" href="{{ route('users.make_user',['id' => $user->id , 'S' => 'default']) }}">Make as User</a></li>
                              @endif
                            @else
                               <li style="font-size:10px;">Can not change role of this user</li>
                            @endif
                          </ul>
                        @endif


                      </div>
                    </td>
                  </tr>
                @endforeach
            </tbody>
          </table>
          {{ $users_data->links() }}
        </div>
      @else
        <center>
          <h1>There are no users currently.</h1>
        </center>
      @endif
    </div>
  </div>
</div>
@stop




@section('css')
  <style media="screen">
       /* body{font-family: Segoe UI;} */
      .content-wrapper {background-color: white;}
  </style>
@stop
