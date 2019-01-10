@extends('layouts.app')
@section('title','Upload')

@section('content')
<div class="container">
  @include('includes.parts.msg')
  @include('includes.parts.err')
</div>

<div class="container" style="min-height:79.5vh;margin-top:30px;">
  <div class="row">
    <div class="col-md-6">
      <div class="upload-screen">
        <h1 class="text-center" style="font-size:2rem;font-weight:100;">ITEM INFO</h1>
        <form class="upload-form" action="{{ route('upload.o_upload') }}" method="post" enctype="multipart/form-data">
          {{ csrf_field() }}

          <!-- File input -->
          <div class="form-group" style="text-align:left;">
            <label style="display:block;" >First Chose The Item File </label>
            <input type="file" name="file">
          </div>

          <!-- Department Select -->
          <div class="form-group" style="text-align:left;">
            <label style="display:block;">What is the Department</label>
            <select class="form-control" name="department_id" id="dptSelect">
              <option value="empty">Select Department</option>
              @foreach($departments as $dept)
                <option value="{{ $dept->id }}">{{ $dept->department_name }}</option>
              @endforeach
            </select>
          </div>

          <!-- Stages Select -->
          <div class="form-group" style="text-align:left;">
            <label style="display:block;">What is the Stage</label>
            <select class="form-control" name="stage_id" id="stgSelect">
              <option dpt-id="none" value="empty">Select Stage</option>
              @foreach($stages as $stg)
                <option dpt-id="{{ $stg->department_id }}" value="{{ $stg->id }}">{{ $stg->stage_name }}</option>
              @endforeach
            </select>
          </div>

          <!-- Subjects Select -->
          <div class="form-group" style="text-align:left;">
            <label style="display:block;">What is the Subject</label>
            <select class="form-control" name="subject_id" id="subSelect">
              <option stg-id="none" dpt-id="none" value="empty">Select Subject</option>
              @foreach($subjects as $subject)
                <option stg-id="{{ $subject->stage_id }}" dpt-id="{{ $subject->department_id }}" value="{{ $subject->id }}">{{ $subject->subject_name }}</option>
              @endforeach
            </select>
          </div>

          <!-- Categoris Select -->
          <div class="form-group" style="text-align:left;">
            <label style="display:block;">Chose Category</label>
            <select class="form-control" name="category_id" id="catSelect">
              <option value="empty">Select Category</option>
              @foreach($categories as $cat)
                <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
              @endforeach
            </select>
          </div>

          <!-- Years Select -->
          <div class="form-group" style="text-align:left;">
            <label style="display:block;">Chose Study Year</label>
            <select class="form-control" name="the_year" id="yrSelect">
              <option value="empty">Select Year</option>
              @foreach($years as $year)
                <option value="{{ $year->the_year }}">{{ $year->the_year }}</option>
              @endforeach
            </select>
          </div>

          <!-- Title Input -->
          <div class="form-group" style="text-align:left;">
            <label style="display:block;">Title</label>
            <input type="text" name="title" class="form-control" placeholder="Write Title Of Thes File ..." required autocomplete="off">
          </div>

          <!-- Discription Input -->
          <div class="form-group" style="text-align:left;">
            <label style="display:block;">Chose Study Year</label>
            <textarea class="form-control" name="discription" rows="8" cols="60" required autocomplete="off" placeholder="Write Discription Her ..."></textarea>
          </div>

          <h6 class="text-center" style="color:#607D8B;">Did you confirm information? Now Click Upload. and Wait a little time <i class="fa fa-smole-o"></i> </h6>
          <button type="submit" name="submit" class="btn btn-primary btn-block"> <i class="fa fa-upload" style="font-size:1.4rem;"></i> Upload</button>
        </form>
      </div>
    </div>
    <div class="col-md-6">
      <center>
        <h1 style="font-size:7rem;font-weight:100;margin:30px;">Upload</h1>
        <p style="font-size:1.2rem;color:#607d8b;" >Upload Items in EASS <br> Can Upload The <span style="color:red;">PDF</span> or <span style="color:blue;">WORD</span> or <span style="color:green;">EXCEL</span> or <span style="color:orange;">POWER POINT</span> and other<i class="fa fa-smile-o"></i> <br> </p>
        <a href="{{ route('upload.upload_in_my_stage') }}" class="btn btn-primary" style="margin:75px;" >Upload In My Current Stage</a>
      </center>
    </div>
  </div>
</div>
@stop


@section('js')
<script type="text/javascript">

function hide_stage_options(){
    // Hide All Options in Stages Select
    $("#stgSelect option").each(function(){
        if($(this).val() != 'empty')
          $(this).hide();
    });
  }

 function hide_subjects_option(){
   // Hide All Options in Subjects Select
   $("#subSelect option").each(function(){
       if($(this).val() != 'empty')
         $(this).hide();
   });
 }


 function show_stages(selected_dpt){
   if(selected_dpt != 'empty')
   {
     $("#stgSelect option").each(function(){
       if($(this).attr("dpt-id") != 'none')
       {
         if($(this).attr("dpt-id") != selected_dpt)
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
     hide_stage_options();
     hide_subjects_option();
   }
 }// Show Stages Function End ----

 function show_subjects(selected_stg){
   $("#subSelect option").each(function(){
     if($(this).attr("stg-id") != 'none')
     {
       if($(this).attr("stg-id") != selected_stg)
       {
         $("#subSelect").val("empty").change();
         $(this).hide();
       }
       else
       {
         $("#subSelect").val("empty").change();
         $(this).show();
       }
     }
     else
     {
       $("#subSelect").val("empty").change();
       $(this).show();
     }
   });
 }// Show Subjects Function End ------


$(document).ready(function (){
  // Hide Options in Stage and Subjects
  hide_stage_options();
  hide_subjects_option();

  // Using Change Eevent on Department Select
  $("#dptSelect").change(function (){
    var val = $(this).val();
    show_stages(val);
  });

  // Using Change Eevent on Stage Select
  $("#stgSelect").change(function (){
    var val = $(this).val();
    show_subjects(val);
  });

});
</script>
@stop



@section('css')
<style media="screen">

  .upload-screen {
    width:100%;
    border:1px solid #FAFAFA;
    border-radius: 0.25rem;
    background-color: #FAFAFA;
    margin: 0px;
    padding: 10px;
  }

  .form-control {
    border-radius: 0rem;
    background-color: #EEE;
  }

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
