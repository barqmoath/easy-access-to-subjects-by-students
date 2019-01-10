@extends('adminlte::page')

@section('title', 'EASS Stages')

@section('content_header')
@include('includes.parts.msg')
@include('includes.parts.err')


<center>
  <h1 style="font-weight:700;font-size:45px;">Stages</h1>
</center>


@stop

@section('content')
  <div class="container">
    <form class="form-inline" action="{{ route('stages.new_stage') }}" method="POST">
      {{ csrf_field() }}
      <select name="department" class="form-control" required>
        <option value="0">Select Departmet</option>
        @foreach($data['departments'] as $department)
          <option value="{{ $department->id }}" >{{ $department->department_name }}</option>
        @endforeach
      </select>
      <div class="form-group">
        <input style="width:250px;" type="text" name="name" class="form-control" placeholder="Enter The Stage name" required autocomplete="off">
      </div>
      <button style="margin-top:1px;" type="submit" name="submit" class="btn btn-default bg-purple"><i class="fa fa-plus"></i> Add Stage</button>
    </form>
  </div>

  <div class="content" style="margin-top:20px;">
    @foreach($data['departments'] as $department)
      <div class="box box-danger" style="border-radius:0px; border-top-color:#605CA8;">
          <div class="box-header with-border">
            <h3 class="box-title">{{ $department->department_name }}</h3>
          </div>
          <div class="box-body">
            <table class="table table-bordered">
                <thead>
                  <th>{{ $department->department_name }} Stages</th>
                  <th class="text-center">Action</th>
              </thead>
              <tbody>
                @foreach($data['stages'] as $stage)
                  @if($stage->department_id === $department->id)
                  <tr>
                    <td>{{ $stage->stage_name }}</td>
                    <td class="text-center">
                      <div class="btn-group">
                        <a href="{{ route('stages.edit_show',['id' => $stage->id]) }}" class="btn btn-default btn-sm" style="width:100px;"><i class="fa fa-edit"></i> Edit</a>
                        <a href="{{ route('stages.delete',['id' => $stage->id]) }}" onclick="return confirm('Be Careful .. You are about to delete a full stage !!!!')" class="btn btn-default btn-sm" style="width:100px;"><i class="fa fa-trash"></i> Delete</a>
                      </div>
                    </td>
                  </tr>
                  @endif
                @endforeach
              </tbody>
            </table>


            <!-- Stages Show Her -->
            @php

            @endphp
          </div>
      </div>
    @endforeach
  </div>
@stop






@section('css')
  <style media="screen">
       /* body{font-family: Segoe UI;} */
      .content-wrapper {background-color: white;}
  </style>
@stop
