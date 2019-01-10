@extends('adminlte::page')

@section('title', 'EASS Study Years')

@section('content_header')
@include('includes.parts.msg')
@include('includes.parts.err')

<center>
  <h1 style="font-weight:700;font-size:45px;">Study Years</h1>
</center>

@stop

@section('content')
<div class="content">
  <!-- Add New Year Form Start -->
  <div class="">
    <form class="form-inline" action="{{ route('years.new_year') }}" method="POST">
      {{ csrf_field() }}
      <div class="form-group">
        <div class="input-group">
          <div class="input-group-addon">
            <i class="fa fa-calendar"></i>
          </div>
          <input name="the_year" type="text" class="form-control" data-inputmask="'alias': 'yyyy'" data-mask="" placeholder="YYYY" autocomplete="off" required>
        </div>
      </div>
      <button style="margin-top:1px;" type="submit" name="submit" class="btn btn-default bg-purple"><i class="fa fa-plus"></i> Add New Year</button>
    </form>
  </div>
  <!-- Add New Year Form End -->

  <div class="box box-danger" style="margin-top:25px;border-radius:0px; border-top-color:#605CA8;">
    <div class="box-body">
      <table class="table table-striped">
        <thead>
          <th class="text-center">ALL STUDY YEARS</th>
        </thead>
        <tbody>
          @foreach($years as $year)
            <tr>
              <td class="text-center" style="font-size:100px;">{{ $year->the_year }}</td>
              <td>
                <a href="{{ route('years.delete',['year' => $year->the_year]) }}" onclick="return confirm('Are you sure ?')" class="btn btn-default btn-sm"><i class="fa fa-trash"></i></a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
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
