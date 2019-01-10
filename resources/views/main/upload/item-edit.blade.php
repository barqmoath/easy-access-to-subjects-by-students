@extends('layouts.app')
@section('title','Edit Items')

@section('content')
<div class="container">
  @include('includes.parts.msg')
  @include('includes.parts.err')
</div>

<div class="container" style="min-height:79.5vh;margin-top:30px;">
  <div class="row">
    <div class="col-md-6">
      <div class="upload-screen">
        <h1 class="text-center" style="font-size:2rem;font-weight:100;">EDIT {{ $item->title }}</h1>
        <form class="upload-form" action="{{ route('item.item_edit_execute') }}" method="POST" enctype="multipart/form-data">
          {{ csrf_field() }}

          <!-- Hidden Old Data Input -->
          <input type="hidden" name="id" value="{{ $item->id }}">
          <input type="hidden" name="oldfile" value="{{ $item->file }}">
          <input type="hidden" name="returnto" value="{{ $item->subject_id }}">
          <!-- File input -->
          <div class="form-group" style="text-align:left;">
            <label style="display:block;" >Leave the file empty if you dont need upload another file ..</label>
            <input type="file" name="file">
          </div>


          <!-- Title Input -->
          <div class="form-group" style="text-align:left;">
            <label style="display:block;">Title</label>
            <input value="{{ $item->title }}" type="text" name="title" class="form-control" placeholder="Write Title Of Thes File ..." required autocomplete="off">
          </div>

          <!-- Discription Input -->
          <div class="form-group" style="text-align:left;">
            <label style="display:block;">Chose Study Year</label>
            <textarea class="form-control" name="discription" rows="8" cols="60" required autocomplete="off" placeholder="Write Discription Her ...">{{ $item->discription }}</textarea>
          </div>

          <h6 class="text-center" style="color:#607D8B;">Now .. Click Save Changes <i class="fa fa-smile-o"></i> </h6>
          <button type="submit" name="submit" class="btn btn-primary btn-block"> <i class="fa fa-upload" style="font-size:1.4rem;"></i> Save Changes</button>
        </form>
      </div>
    </div>
    <div class="col-md-6">
      <center>
        <h1 style="font-size:7rem;font-weight:100;margin:30px;">Edit</h1>
        <p style="font-size:1.2rem;color: #607D8B;" >Can Not Edit Department or Stage or Subject <br> And Can Not Edit Category or Year <br> If You Need Update Them . Delete Item and Upload Agin <i class="fa fa-smile-o"></i> <br> </p>
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
