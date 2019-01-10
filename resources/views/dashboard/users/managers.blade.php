@extends('adminlte::page')

@section('title', 'EASS Managers')

@section('content_header')
@include('includes.parts.msg')
@include('includes.parts.err')

<center>
  <h1 style="font-weight:700;font-size:45px;">Managers</h1>
</center>


@stop

@section('content')

<div class="content">
  <a href="{{ route('users.index',['showState' => 'all-users']) }}" class="btn btn-default bg-purple"> <i class="fa fa-arrow-left"></i> All Users</a>
  <div class="box box-danger" style="border-radius:0px; border-top-color:#605CA8; margin-top: 10px;">
    <div class="box-body">
      @if(count($managers_data) > 0)
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
                  @foreach($managers_data as $user)
                    <tr>
                      <td>{{ $user->name }}@if(Auth::user()->id === $user->id) <span style="font-size:11px; color:#27ae60;">.this is me</span> @endif</td>
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
                          @if(Auth::user()->role === 'Owner')
                            <button style="width:150px;" type="button" class="btn btn-default btn-flat btn-sm dropdown-toggle" data-toggle="dropdown">
                              Change Role
                              <span class="caret"></span>
                              <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu" role="menu" style="border-radius:0px;">
                              @if($user->state === 1)
                                @if($user->role != 'Owner')
                                 <li><a onclick="return confirm('Are you sure?')" href="{{ route('users.make_owner',['id' => $user->id , 'S' => 'managers']) }}">Make as Owner</a></li>
                                @endif
                                @if($user->role != 'Administrator')
                                 <li><a onclick="return confirm('Are you sure?')" href="{{ route('users.make_administrator',['id' => $user->id ,'S' => 'managers']) }}">Make as Administrator</a></li>
                                @endif
                                @if($user->role != 'Uploader')
                                 <li><a onclick="return confirm('Are you sure?')" href="{{ route('users.make_uploader',['id' => $user->id , 'S' => 'default']) }}">Make as Uploader</a></li>
                                @endif
                                @if($user->role != 'User')
                                 <li><a onclick="return confirm('Are you sure?')" href="{{ route('users.make_user',['id' => $user->id, 'S' => 'managers']) }}">Make as User</a></li>
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

        </div>
      @else
        <center>
          <h1>There are no other managers except you</h1>
          <a href="{{ route('users.index',['showState' => 'all-users' ]) }}">Goto all users page</a>
        <center>
      @endif
    </div>
  </div>
</div>

@stop






@section('js')



@stop

@section('css')
  <style media="screen">
       /* body{font-family: Segoe UI;} */
      .content-wrapper {background-color: white;}
  </style>
@stop
