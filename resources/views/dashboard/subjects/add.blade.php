@extends('adminlte::page')

@section('title', 'EASS Subjects')

@section('content_header')
@include('includes.parts.msg')
@include('includes.parts.err')


<center>
  <h1 style="font-weight:700;font-size:45px;">Add Subject</h1>
  <a href="{{ URL::previous() }}" class="btn btn-default btn-sm bg-purple" style="width: 185px;">GO BACK</a>
  <a href="{{ route('subjects.start') }}" class="btn btn-default btn-sm bg-purple" style="width: 185px;">BROWSE</a>
</center>


<hr>
@stop

@section('content')
<div class="content">
  <div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">
      <div class="screen">
        <h3 class="text-center">NEW SUBJECT INFO</h3>
        <form action="{{ route('subjects.add') }}" method="POST" enctype="multipart/form-data">
          {{ csrf_field() }}
          <div class="form-group">
            <label>Subject name</label>
            <input type="text" name="subject_name" class="form-control" placeholder="Enter Subject name" required autocomplete="off">
          </div>

          <div class="form-group">
            <label>Chose Department</label>
            <select class="form-control" name="department_id" id="dptSelect">
              <option value="empty">Please Chose Department</option>
              @foreach($departments as $dpt)
                <option value="{{ $dpt->id }}">{{ $dpt->department_name }}</option>
              @endforeach
            </select>
          </div>

          <div class="form-group">
            <label>Chose Stage</label>
            <select class="form-control" name="stage_id" id="stgSelect">
              <option dpt-id="none" value="empty">Please Chose Stage</option>
              @foreach($stages as $stg)
                <option dpt-id="{{ $stg->department_id }}" value="{{ $stg->id }}">{{ $stg->stage_name }}</option>
              @endforeach
            </select>
          </div>

          <div class="form-group">
            <label>Subject Teacher</label>
            <input type="text" name="teacher_name" value="Unknwon Teacher" class="form-control" placeholder="Enter Teacher Name" required autocomplete="off">
          </div>

          <div class="form-group">
            <label>Subject Description</label>
            <textarea name="discription" rows="8" cols="80" class="form-control" required autocomplete="off" placeholder="Write Description of thes subject ..."></textarea>
          </div>

          <div class="form-group">
            <label>Chose Cover</label>
            <input type="file" name="cover">
            <h6>You can put cover photo of the type : <span style="color:green;">JPG , PNG</span> </h6>
          </div>

          <button type="submit" name="submit" class="btn btn-default bg-purple btn-block"><i class="fa fa-save"></i> Save Subject</button>
        </form>
      </div>
    </div>
    <div class="col-md-3"></div>
  </div>
</div>
@stop



@section('js')
<script type="text/javascript">
$(document).ready(function (){
  // Hide All Options in Stages Select
  $("#stgSelect option").each(function(){
      if($(this).val() != 'empty')
      {
        $(this).hide();
      }
  });

  // Using Change Eevent on Department Select
  $("#dptSelect").change(function (){
    var val = $(this).val();
    if(val != 'empty')
    {
      $("#stgSelect option").each(function(){
        if($(this).attr("dpt-id") != 'none')
        {
          if($(this).attr("dpt-id") != val)
          {
            $("#stgSelect").val("empty").change();
            $(this).hide();
          }
          else
          {
            $("#stgSelect").val("empty").change();
            $(this).show();
          }
        }
      });
    }
    else
    {
      // Hide All Options in Stages Seletc if User not Select Department
      $("#stgSelect").val("empty").change();
      $("#stgSelect option").each(function(){
          if($(this).val() != 'empty')
          {
            $(this).hide();
          }
      });
    }
  });
});
</script>
@stop


@section('css')

<style media="screen">
/* body{font-family: Segoe UI;} */
.content-wrapper {background-color: white;}
.screen {
  margin: 0px;
  padding: 14px;
  border:1px solid #EEE;
  border-radius: 5px;
  background-color: #f4f4f4f4;
}
</style>
@stop
