@extends('adminlte::page')

@section('title', 'EASS Departments')

@section('content_header')
@include('includes.parts.msg')
@include('includes.parts.err')

<center>
  <h1>Edit <strong>{{ $departments->department_name }}</strong> Department</h1>
</center>
@stop

@section('content')
<div class="box box-info" style="width:444px; margin: 5px auto;border-top-color:#605CA8;border-radius:0px;">
  <div class="box-header with-border">
    <h3 class="box-title">{{ $departments->department_name }}</h3>
  </div>
  <form class="form-horizontal" action="{{ route('departments.edit_save') }}" method="POST">
    {{ csrf_field() }}
    <div class="box-body">
      <input type="password" name="id" value="{{ $departments->id }}" style="display:none">
      <div class="form-group">
        <label class="col-sm-2 control-label">Name</label>
        <div class="col-sm-10">
          <input value="{{$departments->department_name}}" type="text" name="name" class="form-control" placeholder="Name" required>
        </div>
      </div>

    </div>
    <div class="box-footer">
      <center>
        <a href="{{ route('departments') }}" class="btn btn-default">Cancel</a>
        <button type="submit" class="btn btn-default bg-purple"><i class="fa fa-edit"></i> Save Changes</button>
      </center>
    </div>
  </form>
</div>
@stop


@section('css')
  <style media="screen">
       /* body{font-family: Segoe UI;} */
      .content-wrapper {background-color: white;}
  </style>
@stop
