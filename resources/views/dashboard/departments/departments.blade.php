@extends('adminlte::page')

@section('title', 'EASS Departments')

@section('content_header')
@include('includes.parts.msg')
@include('includes.parts.err')


<center>
  <h1 style="font-weight:700;font-size:45px;">Departments</h1>
</center>
@stop

@section('content')
  <div class="container">
    <form class="form-inline" action="{{ route('department.new_department') }}" method="POST">
      {{ csrf_field() }}
      <div class="form-group">
        <input style="width:250px;" type="text" name="department_name" class="form-control" placeholder="Enter The Department name" required autocomplete="off">
      </div>
      <button style="margin-top:1px;" type="submit" name="submit" class="btn btn-default bg-purple"><i class="fa fa-plus"></i> Add Department</button>
    </form>
  </div>

  <div class="content" style="margin-top:10px;">
    <div class="box box-danger" style="border-radius:0px; border-top-color:#605CA8;">
      <div class="box-body">
        @if(count($departments) > 0)
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <th>Slug</th>
                <th>Department Name</th>
                <th class="text-center">Action</th>
              </thead>
              <tbody>
                @foreach($departments as $department)
                  <tr>
                    <td>{{ $department->slug }}</td>
                    <td>{{ $department->department_name }}</td>
                    <td class="text-center">
                      <div class="btn-group">
                        <a href="{{ route('departments.edit_show',['slug' => $department->slug]) }}" class="btn btn-default btn-sm" style="width:100px;"><i class="fa fa-edit"></i> Edit</a>
                        <a href="{{ route('departmenst.delete',['slug' => $department->slug]) }}" onclick="return confirm('Be Careful .. You are about to delete a full department !!!!')" class="btn btn-default btn-sm" style="width:100px;"><i class="fa fa-trash"></i> Delete</a>
                      </div>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @else
          <center>
            <h1>NO DATA</h1>
          </center>
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
