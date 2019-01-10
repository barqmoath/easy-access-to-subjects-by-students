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
        <form class="upload-form" action="{{ route('upload.u_upload') }}" method="post" enctype="multipart/form-data">
          {{ csrf_field() }}

          <!-- File input -->
          <div class="form-group" style="text-align:left;">
            <label style="display:block;" >First Chose The Item File </label>
            <input type="file" name="file">
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
        <p style="font-size:1.2rem;color:#607d8b;">Upload Items in EASS <br> Can Upload The <span style="color:red;">PDF</span> or <span style="color:blue;">WORD</span> or <span style="color:green;">EXCEL</span> or <span style="color:orange;">POWER POINT</span> and other <i class="fa fa-smile-o"></i> <br> </p>
        <div class="upload-in">
          <p style="font-size:1.5rem;font-weight:100;margin-top:75px;"> Upload in <br> {{ $department->department_name }} <i class="fa fa-arrow-right"></i> {{ $stage->stage_name }} </p>
          @if(Auth::user()->role === 'Owner' || Auth::user()->role === 'Administrator')
          <a href="{{ route('upload.index') }}" class="btn btn-primary">Upload In Other Stage</a>
          @endif
        </div>
      </center>
    </div>
  </div>
</div>
@stop


@section('js')


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
